<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TripRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TripCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TripCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Trip::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trip');
        CRUD::setEntityNameStrings('trip', 'trips');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('trip_name');
        CRUD::column('photo');
        CRUD::column('trip_start');
        CRUD::column('duration');
        CRUD::column('trip_end');
        CRUD::column('trip_plane');
        CRUD::column('trip_status');
        CRUD::column('note');
        CRUD::column('available_num_passenger');
        CRUD::column('user_id');
        CRUD::column('trip_user_id');
        CRUD::column('total_trip_price');
        CRUD::column('discounts');
        CRUD::column('place_in_trip_price');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TripRequest::class);

        CRUD::field('id');
        CRUD::field('trip_name');
        CRUD::field('photo');
        CRUD::field('trip_start');
        CRUD::field('duration');
        CRUD::field('trip_end');
        CRUD::field('trip_plane');
        CRUD::field('trip_status');
        CRUD::field('note');
        CRUD::field('available_num_passenger');
        CRUD::field('user_id');
        CRUD::field('trip_user_id');
        CRUD::field('total_trip_price');
        CRUD::field('discounts');
        CRUD::field('place_in_trip_price');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
