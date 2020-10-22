<?php

namespace App\Http\Requests;

use App\Models\Commit;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCommitRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('commit_edit');
    }

    public function rules()
    {
        return [
            'repository'  => [
                'string',
                'min:5',
                'max:190',
                'nullable',
            ],
            'avatar'      => [
                'string',
                'min:5',
                'max:190',
                'nullable',
            ],
            'login'       => [
                'string',
                'min:1',
                'max:190',
                'nullable',
            ],
            'message'     => [
                'string',
                'nullable',
            ],
            'commit_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
