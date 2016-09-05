@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-success alert-dismissible hidden">

                    Ton mot de passe a bien été changé.

                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Profil de {{ $user->username }}</div>

                    <!-- Si je suis un invité -->
                    @if (Auth::guest())
                        <div class="panel-body">

                        </div>
                    <!-- Si je suis connecté et que je suis l'utilisateur en question -->
                    @elseif(Auth::user()->id == $user->id)
                        <div class="panel-body">
                            Pour changer de mot de passe, clique sur le bouton ci-dessous. Ton ancien mot de passe te sera demandé.
                            <a class="btn btn-link" id="ChangePwd" href="#">Changer mon mot de passe</a>
                        </div>
                    
                    <!-- Si je suis connecté mais que je ne suis pas l'utilisateur -->
                    @else
                        <div class="panel-body">
                            Mais tu n'es pas {{ $user->username }} ! Mais au moins t'es connecté, c'est bien.
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
