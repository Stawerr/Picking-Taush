<?
@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];
@endphp

@section('content')
@php
use App\Models\History;
Widget::add()->to('after_content')
            ->type('div')
            ->class('row col-md-12 mt-4')
            ->content([
                   [
                        'type'        => 'progress',
                        'class'       => 'card text-white bg-primary mb-2',
                        'value'       =>  History::where('picking_id')->count(),
                        'description' => 'text',
                    ], // registered users widget 
                   [
                        'type'        => 'progress',
                        'class'       => 'card text-white bg-success mb-2',
                        'value'       =>  History::where('taush_id')->count(),
                        'description' => 'text',
                    ], // registered cars widget
                ]
            );

@endphp
@endsection