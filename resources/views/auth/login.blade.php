@extends('adminlte::auth.login')

@section('auth_header', 'Login untuk mengakses Sistem Informasi Kearsipan')

@section('css')
<style>
    body.login-page {
        background-color: #1a1a2e !important;
        min-height: 100vh !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .login-box {
        width: 450px !important;    /* ← default 360px, naikkan sesuai selera */
        margin: 0 auto !important;
        padding: 0 !important;
    }

    .login-box .card {
        width: 100% !important;
    }

    .login-logo {
        text-align: center !important;
        margin-bottom: 30px !important;
        padding: 0 !important;
    }

    /* Kecilkan logo agar sesuai form */
    .login-logo img {
        width: 280px !important;    /* ← ubah angka ini sesuai selera */
        height: auto !important;
        max-height: none !important;
        object-fit: contain !important;
        display: block !important;
        margin: 0 auto !important;
    }

    .card {
        background-color: #16213e !important;
        border: 1px solid #0f3460 !important;
        margin: 0 !important;
        width: 100% !important;
    }

    .card-body {
        background-color: #16213e !important;
        color: #ffffff !important;
        padding: 20px 25px !important;
    }

    p.login-box-msg {
        color: #a0aec0 !important;
        margin-bottom: 10px !important;
    }

    .form-control {
        background-color: #0f3460 !important;
        border-color: #1a4a7a !important;
        color: #ffffff !important;
    }

    .form-control::placeholder {
        color: #718096 !important;
    }

    .input-group-text {
        background-color: #0f3460 !important;
        border-color: #1a4a7a !important;
        color: #a0aec0 !important;
    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0px 1000px #0f3460 inset !important;
        -webkit-text-fill-color: #ffffff !important;
        caret-color: #ffffff !important;
        border-color: #1a4a7a !important;
        transition: background-color 5000s ease-in-out 0s !important;
    }
</style>
@endsection