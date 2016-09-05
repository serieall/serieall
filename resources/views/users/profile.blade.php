@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-success alert-dismissible hidden">

                    Le mot de passe a bien été mis à jour.

                </div>
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
                            Modifier votre mot de passe :<a class="btn btn-link" id="ChangePwd" href="#">Ici</a>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Modification du mot de passe</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form id="formChangePwd" class="form-horizontal" role="form" method="POST" action="{{ url('/changepassword') }}">
                                            {!! csrf_field() !!}

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Mot de passe actuel</label>
                                                <div class="col-md-6">
                                                    <input type="password" class="form-control" name="password">
                                                    <small class="help-block"></small>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Ancien mot de passe</label>
                                                <div class="col-md-6">
                                                    <input type="password" class="form-control" name="password_new">
                                                    <small class="help-block"></small>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Confirmer le nouveau mot de passe</label>
                                                <div class="col-md-6">
                                                    <input type="password" class="form-control" name="password_confirmation">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        Confirmer
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
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
