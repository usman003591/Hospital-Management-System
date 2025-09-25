<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosMedicineCategory extends Model
{
     use SoftDeletes, HasFactory;

    public $table = 'pos_medicine_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'image_name',
        'image_path',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function list($request = false)
    {
        try {
            if ($request === false) { $request = request(); }

            $data = self::where('status',1)->get();
            $response =  'medicine category listed successfully';
            return response()->json([
                'response' => [
                    'message' => $response,
                    'status' => 200,
                    'data' => $data
                ],
            ]);

        } catch (\Exception $e) {
            $response =  $e->getMessage();
            return response()->json([
                'response' => [
                    'message' => $response,
                    'status' => 400,
                ],
            ]);
        } catch (\Throwable $e) {
            $response =  $e->getMessage();
            return response()->json([
                'response' => [
                    'message' => $response,
                    'status' => 400,
                ],
            ]);
        }
    }
}
