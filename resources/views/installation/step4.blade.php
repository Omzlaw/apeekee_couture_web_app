@extends('layouts.blank')
@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12">
                <div class="mar-ver pad-btm text-center">
                    <h1 class="h3">Import Software Database</h1>
                </div>
                <p class="text-muted font-13 text-center">
                    <strong>Database is connected <i class="fa fa-check"></i></strong>. Proceed
                    <strong>Press Install</strong>.
                    This automated process will configure your database.
                </p>
                <div class="text-center mar-top pad-top">
                    <a href="{{ route('import_sql') }}" class="btn btn-info" onclick="showLoder()">Import Database</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function showLoder() {
            $('#loading').fadeIn();
        }
    </script>
@endsection
