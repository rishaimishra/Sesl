<?php

function camel_case($str)
{
    return \Illuminate\Support\Str::camel($str);
}

function generateOtp()
{
    return rand(1000, 9999);
}

function alertSuccess($message): array
{
    return [
        'alert' => [
            'status' => 'success',
            'message' => $message
        ]
    ];
}

function alertDanger($message): array
{
    return [
        'alert' => [
            'status' => 'danger',
            'message' => $message
        ]
    ];
}


function yearFilter()
{
    $years = [];

    for ($i = date('Y'); $i >= (date('Y') - 20); $i--) {
        $years[$i] = $i;
    }

    return collect($years)->prepend('Select Year', '');
}

function dwmFilter()
{
    $dwm = [];

    /*for ($i = date('Y'); $i >= (date('Y') - 20); $i--) {
        $years[$i] = $i;
    }*/
    $dwm = ['Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly'];
    /* $dwm['Weekly '] = ['Weekly '];
     $dwm['Monthly'] = ['Monthly'];*/

    return collect($dwm)->prepend('Select', '');
}
