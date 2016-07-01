<?php

namespace AppTest\Services;

use App\Services\PersonalDetailsStorage;
use ArrayIterator;
use ArrayObject;
use League\Csv\Reader;
use League\Csv\Writer;
use PHPUnit\Framework\TestCase;

class PersonalDetailsStorageTest extends TestCase
{

    public function testFindRecordById()
    {
        $reader = $this->createMock(Reader::class);

        $record1 = [87];
        $record2 = [78];

        $reader->expects($this->exactly(3))
            ->method('fetch')
            ->willReturn(new ArrayIterator([$record1, $record2]));

        $storage = new PersonalDetailsStorage($reader);
        $this->assertEquals($record1[0], $storage->get($record1[0])['id']);
        $this->assertEquals($record2[0], $storage->get($record2[0])['id']);
        $this->assertEquals(null, $storage->get(345));
    }

    public function testFindAllRecords()
    {
        $reader = $this->createMock(Reader::class);

        $rows = [
            [87],
            [78]
        ];

        $reader->expects($this->exactly(1))
            ->method('fetch')
            ->willReturn(new ArrayIterator($rows));

        $storage = new PersonalDetailsStorage($reader);
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
        $writer = $this->createMock(Writer::class);

        $writer->expects($this->exactly(1))
            ->method('insertOne');

        $storage = new PersonalDetailsStorage(null, $writer);
        $record = new ArrayObject(['name' => 'asdfasdf']);
        $storage->create($record);
        $this->assertArrayHasKey('id', $record);
    }
}
