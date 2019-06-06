@extends('principal')
@section('contenido')
    <template v-if="menu==0">
        <menu1-component></menu1-component>
    </template>
    <template v-if="menu==1">
        <example-component></example-component>
    </template>
@endsection