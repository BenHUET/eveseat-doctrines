@extends('web::layouts.grids.6-6')

@section('title', trans('doctrines::meta.plugin_name') . ' | ' . trans('doctrines::meta.title_manage_category'))
@section('page_header', trans('doctrines::meta.title_manage_category'))

@section('left')

	@include('doctrines::category.includes.manage.create')

@stop

@section('right')

	@include('doctrines::category.includes.manage.edit')

@stop

@include('doctrines::category.modals.manage.delete_confirm')
@include('doctrines::category.modals.manage.update')

@push('head')
	<link rel="stylesheet" href="{{ asset('web/css/kassie/doctrines/general.css') }}" />
@endpush

@push('javascript')
	<script src="{{ asset('web/js/kassie/doctrines/manage_category.js') }}"></script>
@endpush