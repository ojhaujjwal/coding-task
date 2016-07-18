<?php

namespace AppTest\Acceptance;

use App\Services\PersonalDetailsStorage;
use Faker\Factory as FakerFactory;
use SplTempFileObject;

class PersonalDetailsRoutesTest extends \TestCase
{
    private $faker;
    private $storage;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->storage = PersonalDetailsStorage::createFromFileObject(new SplTempFileObject());
        $this->instance(PersonalDetailsStorage::class, $this->storage);
    }

    public function testListAllDoesNotReturnAnyRecordAtFirst()
    {
        $this->visit('/personal-details')
            ->see(\Lang::get('personal_details.title.list'))
            ->see(\Lang::get('personal_details.messages.no_records'));
    }

    private function storeInputs($inputs)
    {
        foreach ($inputs as $element => $value) {
            $this->storeInput($element, $value);
        }

        return $this;
    }

    protected function createRecord()
    {
        return [
            'name' => $this->faker->name,
            'gender' => 'm',
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'nationality' => 'NP',
            'preferred_contact_mode' => 'p',
        ];
    }

    public function testCreateRecord()
    {
        $this->visit('/personal-details/create')
            ->storeInputs($this->createRecord())
            ->press(\Lang::get('personal_details.add'))
            ->see(\Lang::get('personal_details.title.list'))
            ->dontSee(\Lang::get('personal_details.messages.no_records'));
    }

    public function testValidateEmailAddress()
    {
        $details = [
            'name' => $this->faker->name,
            'gender' => 'm',
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->phoneNumber, // invalid
            'nationality' => 'NP',
            'preferred_contact_mode' => 'p',
        ];
        $this->visit('/personal-details/create')
            ->storeInputs($details)
            ->press(\Lang::get('personal_details.add'))
            ->see(\Lang::get('validation.email', ['attribute' => 'email']));
    }

    public function testListAllRecords()
    {
        $this->visit('/personal-details')
            ->see(\Lang::get('personal_details.title.list'))
            ->see(\Lang::get('personal_details.messages.no_records'))
            ->visit('/personal-details/create')
            ->storeInputs($this->createRecord())
            ->press(\Lang::get('personal_details.add'))
            ->visit('/personal-details/create')
            ->storeInputs($this->createRecord())
            ->press(\Lang::get('personal_details.add'))
            ->visit('/personal-details/create')
            ->storeInputs($this->createRecord())
            ->press(\Lang::get('personal_details.add'))
            ->see(\Lang::get('personal_details.title.list'))
            ->dontsee(\Lang::get('personal_details.messages.no_records'));
    }

    public function testViewRecord()
    {
        $record = $this->createRecord();
        $this->visit('/personal-details/create')
            ->storeInputs($record)
            ->press(\Lang::get('personal_details.add'))
            ->see(\Lang::get('personal_details.title.list'))
            ->click($record['name'])
            ->see(\Lang::get('personal_details.title.view'))
            ->see($record['name']);
    }
}
