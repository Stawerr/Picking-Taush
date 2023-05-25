{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-question"></i> Users</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('picking') }}"><i class="nav-icon la la-question"></i> Pickings</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('taush') }}"><i class="nav-icon la la-question"></i> Taushes</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('history') }}"><i class="nav-icon la la-question"></i> Histories</a></li>