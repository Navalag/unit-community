<?php

namespace App\Http\Requests\Channels;

class CreateChannelRequest extends UpdateChannelRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50', 'unique:channels'],
            'description' => ['required', 'string', 'max:100'],
        ];
    }

    public function getRedirectUrl()
    {
        return parent::getRedirectUrl() . '#createChannel';
    }
}
