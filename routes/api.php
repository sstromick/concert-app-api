<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//export routs needs to be unsecured to work
Route::get('users-export', 'UsersController@export');
Route::get('notes-export', 'NotesController@export');
Route::get('countries-export', 'CountriesController@export');
Route::get('states-export', 'StatesController@export');
Route::get('venues-export', 'VenuesController@export');
Route::get('contactmasters-export', 'ContactMastersController@export');
Route::get('contacts-export', 'ContactsController@export');
Route::get('artists-export', 'ArtistsController@export');
Route::get('events-export', 'EventsController@export');
Route::get('shifts-export', 'ShiftsController@export');
Route::get('shift-scheduless-export', 'ShiftSchedulesController@export');
Route::get('volunteers-export', 'VolunteersController@export');
Route::get('volunteershifts-export', 'VolunteerShiftsController@export');
Route::get('nonprofits-export', 'NonProfitsController@export');
Route::get('nonprofitshifts-export', 'NonProfitShiftsController@export');
Route::get('emailtemplates-export', 'EmailTemplatesController@export');
Route::get('emails-export', 'EmailsController@export');
Route::get('tags-export', 'TagsController@export');
Route::post('volunteershifts', 'VolunteerShiftsController@store');
Route::patch('volunteershifts/{volunteershift}', 'VolunteerShiftsController@update');
Route::put('volunteershifts/{volunteershift}', 'VolunteerShiftsController@update');

Route::group([
    'middleware' => 'api_token'
], function() {

    /**
     * Users
     */
    Route::post('users', 'UsersController@store');
    Route::patch('users/{user}', 'UsersController@update');
    Route::delete('users/{user}', 'UsersController@destroy');
    Route::post('users/login', 'UsersController@login');

    Route::middleware('auth:api')->post('users/logout', 'UsersController@logout');
    Route::middleware('auth:api')->post('users/me', 'UsersController@me');
    Route::get('users', 'UsersController@index');
    Route::get('users/{user}', 'UsersController@show');
    Route::get('users-search', 'UsersController@search');
    /**
     * Search
     */
    Route::get('search', 'SearchController@index');

    /**
     * Reports
     */
    Route::post('reports', 'ReportsController@generate');
    Route::get('dashboard-totals', 'ReportsController@getDashboardTotals');

    /**
     * Notes
     */
    Route::resource('notes', 'NotesController');

    /**
     * Countries
     */
    Route::resource('countries', 'CountriesController');
    Route::get('countries-list', 'CountriesController@list');

    /**
     * States
     */
    Route::resource('states', 'StatesController');
    Route::get('states-list', 'StatesController@list');

    /**
     * Venues
     */
    Route::resource('venues', 'VenuesController');
    Route::get('venues-list', 'VenuesController@list');
    Route::get('venues-search', 'VenuesController@search');
    Route::post('venues-upload-photo/{venue}', 'VenuesController@uploadPhoto');
    Route::post('venues-merge/{venue}', 'VenuesController@merge');

    /**
     * Contact Masters
     */
    Route::resource('contactmasters', 'ContactMastersController');
    Route::get('contactmasters-list', 'ContactMastersController@list');
    Route::get('contactmasters-search', 'ContactMastersController@search');

    /**
     * Contacts
     */
    Route::resource('contacts', 'ContactsController');
    Route::get('contacts-list', 'ContactsController@list');
    Route::get('contacts-search', 'ContactsController@search');

    /**
     * Artists
     */
    Route::resource('artists', 'ArtistsController');
    Route::get('artists-list', 'ArtistsController@list');
    Route::get('artists-search', 'ArtistsController@search');
    Route::post('artists-upload-photo/{artist}', 'ArtistsController@uploadPhoto');

    /**
     * Events
     */
    Route::resource('events', 'EventsController');
    Route::get('events-list', 'EventsController@list');
    Route::get('events-no-paginate', 'EventsController@searchNoPaginate');
    Route::get('events-search', 'EventsController@search');
    Route::post('events-upload-photo/{event}', 'EventsController@uploadPhoto');

    /**
     * Shifts
     */
    Route::resource('shifts', 'ShiftsController');
    Route::get('shifts-list', 'ShiftsController@list');
    Route::get('shifts-all', 'ShiftsController@searchAll');
    Route::get('shifts-search', 'ShiftsController@search');

    /**
     * Shift Schedules
     */
    Route::resource('shiftschedules', 'ShiftSchedulesController');

    /**
     * Volunteers
     */
    Route::resource('volunteers', 'VolunteersController');
    Route::get('volunteers-list', 'VolunteersController@list');
    Route::get('volunteers-pending', 'VolunteersController@pendingVolunteers');
    Route::get('volunteers-search', 'VolunteersController@search');
    Route::post('volunteers-upload-photo/{volunteer}', 'VolunteersController@uploadPhoto');
    Route::post('volunteers-merge/{volunteer}', 'VolunteersController@merge');
    Route::post('volunteers-mass-delete', 'VolunteersController@massDelete');

    /**
     * Volunteer Shifts
     */
    Route::delete('volunteershifts/{volunteershift}', 'VolunteerShiftsController@destroy');
    Route::get('volunteershifts', 'VolunteerShiftsController@index');
    Route::get('volunteershifts/{volunteershift}', 'VolunteerShiftsController@show');
    Route::get('volunteershifts-getshifts', 'VolunteerShiftsController@getVolunteerShiftsByVolunteer');
    Route::get('volunteershifts-pending', 'VolunteerShiftsController@getPendingShifts');
    Route::post('volunteershifts-update-status', 'VolunteerShiftsController@updateStatus');
    Route::post('volunteershifts-mass-delete', 'VolunteerShiftsController@massDelete');

    /**
     * NonProft
     */
    Route::resource('nonprofits', 'NonProfitsController');
    Route::get('nonprofits-no-paginate', 'NonProfitsController@noPaginate');
    Route::get('nonprofits-list', 'NonProfitsController@list');
    Route::get('nonprofits-search', 'NonProfitsController@search');
    Route::post('nonprofits-upload-photo/{nonprofit}', 'NonProfitsController@uploadPhoto');
    Route::post('nonprofits-merge/{nonprofit}', 'NonProfitsController@merge');

    /**
     * NonProfit Shifts
     */
    Route::resource('nonprofitshifts', 'NonProfitShiftsController');
    Route::post('nonprofitshifts-update-shifts', 'NonProfitShiftsController@updateShifts');

    /**
     * Email Templates
     */
    Route::resource('emailtemplates', 'EmailTemplatesController');
    Route::get('emailtemplates-list', 'EmailTemplatesController@list');
    Route::get('emailtemplates-event', 'EmailTemplatesController@getEventTemplates');

    /**
     * Emails
     */
    Route::resource('emails', 'EmailsController');
    Route::post('emails-ondemand', 'EmailsController@sendOnDemanEmails');
    Route::get('emails-search', 'EmailsController@search');

    /**
     * Settings
     */
    Route::resource('settings', 'SettingsController');
    Route::get('settings-no-paginate', 'SettingsController@noPaginate');

    /**
     * Tags
     */
    Route::resource('tags', 'TagsController');

    /**
     * Metrics
     */
    Route::resource('metrics', 'MetricsController');
    Route::get('metrics-no-paginate', 'MetricsController@noPaginate');

    /**
     * MetricValues
     */
    Route::resource('metric-values', 'MetricValuesController');
    Route::get('metric-values-no-paginate', 'MetricValuesController@noPaginate');
    Route::post('metric-values-update-metrics', 'MetricValuesController@updateMetrics');

});
