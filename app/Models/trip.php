<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\vendorInfo;

class trip extends Model
{
    use HasFactory;
        public function user()
        {
            return $this->belongsTo(User::class,'customer_id');
        }

        public function vendorinfo_trip()
        {
            return $this->belongsTo(vendorInfo::class,'vendor_id');
        }
    
}
