<?php

namespace App\Models\Count;

use Illuminate\Database\Eloquent\Model;

class ApiHitRecord extends Model
{
    protected $primaryKey = 'api_hit_record_id';
    protected $table = 'api_hit_records';

    protected $fillable = [
        'api_visitor_ip',
        'api_visitor_platform',
        'api_visitor_browser_name',
        'api_visitor_browser_version',
        'api_visitor_os_type',
        'api_path',
        'api_version',
        'api_visitor_device_type',
        'api_visitor_device_brand',
        'api_visitor_device_model',
        'api_visitor_location_latitude',
        'api_visitor_location_longitude',
        'api_visitor_location_city',
        'api_visitor_location_country',
        'api_visit_time',
    ];
}
