<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class RequestValidator
{
    public function validate($data)
    {
        $validator = Validator::make($data, [
                'users.*.id' => 'required|string|max:10',
                'users.*.name' => 'required|string',
                'users.*.age' => 'required|integer',
                'users.*.companies.*.id' => 'required|string|max:10',
                'users.*.companies.*.name' => 'required|string',
                'users.*.companies.*.started_at' => 'required|date',
            ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
    }
}
