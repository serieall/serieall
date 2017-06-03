@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="six wide column">
            <div class="ui pilled segment">
                <!-- Si je suis un invité -->
                @if (Auth::guest())
                    Voici le profil de {{ $user->username }}, mais étant invité, vous n'avez pas accès au contenu.
                <!-- Si je suis connecté et que je suis l'utilisateur en question -->
                @elseif(Auth::user()->id == $user->id)
                    <h1 class="div-center">Modification de votre mot de passe</h1>
                    <form class="ui form" role="form" method="POST" action="{{ url('/changepassword') }}">
                        {{ csrf_field() }}
                        <br />

                        <div class="field {{ $errors->has('password') ? ' error' : '' }}">
                            <label>Mot de passe</label>
                            <input name="password" placeholder="Mot de passe" type="password" value="{{ old('password') }}">

                            @if ($errors->has('password'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="field {{ $errors->has('new_password') ? ' error' : '' }}">
                            <label>Mot de passe</label>
                            <input name="new_password" placeholder="Mot de passe" type="password" value="{{ old('new_password') }}">

                            @if ($errors->has('new_password'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="field {{ $errors->has('new_password_confirmation') ? ' error' : '' }}">
                            <label>Mot de passe</label>
                            <input name="new_password_confirmation" placeholder="Mot de passe" type="password" value="{{ old('new_password_confirmation') }}">

                            @if ($errors->has('new_password_confirmation'))
                                <div class="ui red message">
                                    <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="div-center">
                            <button class="positive ui button" type="submit">Valider</button>
                        </div>
                    </form>
                <!-- Si je suis connecté mais que je ne suis pas l'utilisateur -->
                @else
                    Mais vous n'êtes pas {{ $user->username }} ! Mais au moins vous êtes connecté. Bien.
                @endif
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
