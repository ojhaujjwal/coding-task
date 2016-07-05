<?php

namespace AppTest\Services;

use App\Services\PersonalDetailsStorage;
use ArrayIterator;
use ArrayObject;
use League\Csv\Reader;
use League\Csv\Writer;
use PHPUnit\Framework\TestCase;
use SplTempFileObject;

class PersonalDetailsStorageTest extends TestCase
{

    public function testFindRecordById()
    {
        $reader = $this->createMock(Reader::class);
        $writer = $this->createMock(Writer::class);

        $record1 = [87];
        $record2 = [78];

        $reader->expects($this->exactly(3))
            ->method('fetch')
            ->willReturn(new ArrayIterator([$record1, $record2]));

        $storage = new PersonalDetailsStorage($reader, $writer);
        $this->assertEquals($record1[0], $storage->get($record1[0])['id']);
        $this->assertEquals($record2[0], $storage->get($record2[0])['id']);
        $this->assertEquals(null, $storage->get(345));
    }

    public function testFindAllRecords()
    {
        $reader = $this->createMock(Reader::class);
        $writer = $this->createMock(Writer::class);

        $rows = [
            [87],
            [78]
        ];

        $reader->expects($this->exactly(1))
            ->method('fetch')
            ->willReturn(new ArrayIterator($rows));

        $storage = new PersonalDetailsStorage($reader, $writer);
        $records = $storage->all();

        $count = 0;
        foreach($records as $i => $record) {
            $this->assertEquals($rows[$i][0], $record['id']);
            $count++;
        }

        $this->assertEquals(2, $count);
    }

    public function testCreateRecord()
    {
        $reader = $this->createMock(Reader::class);
        $writer = $this->createMock(Writer::class);

        $writer->expects($this->exactly(1))
            ->method('insertOne');

        $storage = new PersonalDetailsStorage($reader, $writer);
        $record = new ArrayObject(['name' => 'asdfasdf']);
        $storage->store($record);
        $this->assertArrayHasKey('id', $record);
    }

    public function testCreatingNewRecordDoesNotRemovePreviousRecords()
    {
        $file = __DIR__ . '/../../resources/personal-details.csv';
        if (!file_exists($file)) {
            touch($file);
        }
        $reader = $this->createMock(Reader::class);
        //Override the file for starting fresh
        $writer = Writer::createFromPath($file, 'w');
        $storage = new PersonalDetailsStorage($reader, $writer);
        $storage->store(new ArrayObject(['name' => 'Record 1']));

        // create a new instance to test if records are appended or overridden
        $storage = PersonalDetailsStorage::createFromPath($file);
        $storage->store(new ArrayObject(['name' => 'Record 2']));
        $this->assertEquals(2, count($storage));
    }

    public function testFindByEmail()
    {
        $tempFile = new SplTempFileObject();
        $storage = PersonalDetailsStorage::createFromFileObject($tempFile);
        $records = [new ArrayObject(['email' => 'a1@test.com']), new ArrayObject(['email' => 'b1@test.com'])];
        foreach($records as $record) {
            $storage->store($record);
        }
        foreach($records as $record) {
            $this->assertEquals($record['email'], $storage->findByEmail($record['email'])['email']);
        }
        $this->assertNull($storage->findByEmail('asdf@test.com'));
    }

    public function testCountRecords()
    {
        $tempFile = new SplTempFileObject();
        $storage = PersonalDetailsStorage::createFromFileObject($tempFile);
        $records = [new ArrayObject(['' => 32]), new ArrayObject(['id' => 63])];
        foreach($records as $record) {
            $storage->store($record);
        }
        $this->assertEquals(2, count($storage));
    }

    public function testGetSliceOfResults()
    {
        $tempFile = new SplTempFileObject();
        $storage = PersonalDetailsStorage::createFromFileObject($tempFile);
        $records = [
            new ArrayObject(['id' => 45]),
            new ArrayObject(['id' => 83]),
            new ArrayObject(['id' => 63]),
            new ArrayObject(['id' => 53])
        ];
        foreach($records as $record) {
            $storage->store($record);
        }

        $slicedRecords = $storage->getSlice(1, 2);

        $count = 0;
        foreach($slicedRecords as $i => $record) {
            $this->assertEquals($records[1 + $i]['id'], $record['id']);
            $count++;
        }

        $this->assertEquals(2, $count);

        // there are only 4 records in total
        // so should return only 1 record
        $slicedRecords = iterator_to_array($storage->getSlice(3, 2));
        $this->assertCount(1, $slicedRecords);
        $this->assertEquals($records[3]['id'], $slicedRecords[0]['id']);

        // there are only 4 records in total
        // so can't find any record after 3rd offset
        $this->assertEquals(0, iterator_count($storage->getSlice(4, 2)));
    }
}
