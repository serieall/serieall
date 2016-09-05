@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Profil de {{ $user->username }}</div>

                    <!-- Si je suis un invité -->
                    @if (Auth::guest())
                        <div class="panel-body">
                            Voici le profil de {{ $user->username }}, mais étant invité, vous n'avez pas accès au contenu.
                        </div>
                    <!-- Si je suis connecté et que je suis l'utilisateur en question -->
                    @elseif(Auth::user()->id == $user->id)
                        <div class="panel-body">
                            <a href="#demo" class="btn btn-info" data-toggle="collapse">Modifier votre mot de passe</a>

                            <div id="demo" class="collapse in">
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/changepassword') }}">
                                {{ csrf_field() }}

                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    @if (session('warning'))
                                        <div class="alert alert-warning">
                                            {{ session('warning') }}
                                        </div>
                                    @endif

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label">Mot de passe actuel</label>

                                        <div class="col-md-6">
                                            <input id="password_old" type="password" class="form-control" name="password" value="{{ old('password') }}">

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                        <label for="new_password" class="col-md-4 control-label">Nouveau mot de passe</label>

                                        <div class="col-md-6">
                                            <input id="new_password" type="password" class="form-control" name="new_password" value="{{ old('new_password') }}">

                                            @if ($errors->has('new_password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('new_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                                        <label for="new_password_confirmation" class="col-md-4 control-label">Confirmation du nouveau mot de passe</label>

                                        <div class="col-md-6">
                                            <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}">

                                            @if ($errors->has('new_password_confirmation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-btn fa-key"></i> Confirmer
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    <!-- Si je suis connecté mais que je ne suis pas l'utilisateur -->
                    @else
                        <div class="panel-body">
                            Mais vous n'êtes pas {{ $user->username }} ! Mais au moins vous êtes connecté. Bien.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>

        $(function(){

            $('#ChangePwd').click(function() {
                $('#myModal').modal();
            });

            $(document).on('submit', '#formChangePwd', function(e) {
                e.preventDefault();

                $('input+small').text('');
                $('input').parent().removeClass('has-error');

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json"
                })
                        .done(function(data) {
                            $('.alert-success').removeClass('hidden');
                            $('#myModal').modal('hide');
                        })
                        .fail(function(data) {
                            $.each(data.responseJSON, function (key, value) {
                                var input = '#formChangePwd input[name=' + key + ']';
                                $(input + '+small').text(value);
                                $(input).parent().addClass('has-error');
                            });
                        });
            });

        })

    </script>

@endsection
