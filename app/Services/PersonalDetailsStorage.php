<?php

namespace App\Services;

use League\Csv\Reader;
use League\Csv\Writer;
use Ramsey\Uuid\Uuid;
use ArrayObject;
use SplFileObject;

class PersonalDetailsStorage
{
    CONST FILE = __DIR__.'/../../storage/personal-details.csv';

    private $reader;
    private $writer;
    private $fields = [
        'id',//0
        'name',
        'gender',
        'phone',
        'email',//4
        'address',
        'nationality',
        'educational_background',
        'preferred_contact_mode'
    ];

    /**
     * Initializes the object
     * Creates instances of reader and writer
     *
     * @param Reader $reader
     * @param Writer $writer
     */
    public function __construct(Reader $reader, Writer $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    /**
     * Return a new instance from a path string
     *
     * @param mixed $file File path
     *
     * @return self
     */
    public static function createFromPath($file = self::FILE)
    {
        $reader = Reader::createFromPath($file);
        $writer = Writer::createFromPath($file, 'a');
        return new self($reader, $writer);
    }

    /**
     * Return a new instance from a SplFileObject
     *
     * @param SplFileObject $file
     *
     * @return self
     */
    public static function createFromFileObject(SplFileObject $file)
    {
        $reader = Reader::createFromFileObject($file);
        $writer = Writer::createFromFileObject($file);
        return new self($reader, $writer);
    }

    /**
     * Stores a record as a CSV row in CSV file
     *
     * @param ArrayObject $personalDetails
     * @return void
     */
    public function store(ArrayObject $personalDetails)
    {
        $personalDetails['id'] = Uuid::uuid4()->toString();
        $this->writer->insertOne($this->objectToRow($personalDetails));
    }

    /**
     * Find a record by id
     *
     * @param string $id
     * @return ArrayObject|null
     */
    public function get($id)
    {
        foreach($this->reader->fetch() as $row) {
            if ($row[0] === $id) {
                return $this->rowToObject($row);
            }
        }
    }

    /**
     * Find a record by email
     *
     * @param string $email
     * @return ArrayObject|null
     */
    public function findByEmail($email)
    {
        foreach($this->reader->fetch() as $row) {
            if (isset($row[4]) && $row[4] === $email) {
                return $this->rowToObject($row);
            }
        }
    }

    /**
     * Fetch the next record from the CSV file
     *
     * @return \Generator<ArrayObject>
     */
    public function all()
    {
        foreach($this->reader->fetch() as $row) {
            yield $this->rowToObject($row);
        }
    }

    /**
     * Converts CSV row to PersonalDetails ArrayObject
     *
     * @param array $row
     * @return ArrayObject
     */
    private function rowToObject($row)
    {
        $ob = new ArrayObject();
        foreach($this->fields as $i => $field) {
            if (!isset($row[$i])) break;
            $ob[$field] = $row[$i];
        }

        return $ob;
    }


    /**
     * Converts PersonalDetails ArrayObject to CSV row
     *
     * @param ArrayObject $ob
     * @return array
     */
    private function objectToRow($ob)
    {
        return array_map(function($field) use ($ob) {
            return isset($ob[$field]) ? $ob[$field] : '';
        }, $this->fields);
    }
}
