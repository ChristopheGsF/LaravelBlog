@extends('layouts.app')
@include('messages.success')

@section('content')
<script>
$(document).ready(function(){
  $("a").on('click', function(event)
              {
                if (this.hash !== "")
                {
                  event.preventDefault();
                  var hash = this.hash;
                  $('html, body').animate(
                  {
                    scrollTop: $(hash).offset().top
                  }, 800, function()
                  {
                    window.location.hash = hash;
                  });
                }
              });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h1 class="text-center">{{$user->name}}</h1>
                    @if ($user->img)
                      <img src="{{$user->img}}" style="width : 200px; height : auto; float:left;" alt="img-article">
                    @else
                      <div class="col-md-6">
                        <p>Cet(te) utilisateur n'a pas d'image de profil pour l'instant</p>
                      </div>
                    @endif
                    @if (Auth::check())
                      @if (Auth::user()->id == $user->id)
                        <div class="col-md-6">
                          <div class="col-md-12">
                            <p>Tu es connecté en tant que : {{$user->name}} !</p>
                            <p>Ton email est : {{$user->email}}.</p>
                            <p>Compte crée le : {{$user->created_at}}.</p>
                          </div>
                          <div class="col-md-12">
                            {!! Form::open(
                                array(
                                    'route' => 'user.edit_img',
                                    'class' => 'form',
                                    'novalidate' => 'novalidate',
                                    'files' => true)) !!}
                              <div class="form-group">
                                  {!! Form::label("Pour changer d'image de profil") !!}
                                  {!! Form::file('image', null) !!}
                              </div>
                              <div class="form-group">
                                  {!! Form::submit('Télécharger une image !') !!}
                              </div>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      @elseif (Auth::user()->isAdmin)
                        <div class="col-md-6">
                          <div class="col-md-12">
                            <p>En tant qu'administrateur tu peux modifier à loisir les articles de {{$user->name}} !</p>
                            <p>En cliquant juste ici ou en regardant plus bas !</p>
                            <a href="#articles"><img src="http://icon-icons.com/icons2/936/PNG/512/hand-finger-pointing-down_icon-icons.com_73538.png" alt="Doigt qui pointe vers le bas" style="width : 100px; height : auto;"></a>
                          </div>
                        </div>
                      @else
                        <div class="col-md-6">
                          <div class="col-md-12">
                            <p>Tu pourras voir ici tous les articles écrites par {{$user->name}} !</p>
                            <p>Intéressant ? Non ?</p>
                            <a href="#articles"><img src="http://icon-icons.com/icons2/936/PNG/512/hand-finger-pointing-down_icon-icons.com_73538.png" alt="Doigt qui pointe vers le bas" style="width : 100px; height : auto;"></a>
                          </div>
                        </div>
                      @endif
                    @endif
                    @if (!Auth::check())
                      <div class="col-md-6">
                          <div class="col-md-12">
                            <p>Tu pourras voir ici tous les articles écrites par {{$user->name}} !</p>
                            <p>Intéressant ? Non ?</p>
                            <a href="#articles"><img src="http://icon-icons.com/icons2/936/PNG/512/hand-finger-pointing-down_icon-icons.com_73538.png" alt="Doigt qui pointe vers le bas" style="width : 100px; height : auto;"></a>
                          </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <table class="table table-hover" id="articles">
            <thead>
              <tr>
                <td> Titre </td>
                <td> Content </td>
              </tr>
            </thead>
            <tbody>
              @foreach ($articles as $article)
              <tr>
                <td><a href="{{ route('articles.index') }}/{{$article->id}}/show">{{$article->title}}</a></td>
                <td> {{$article->content}} </td>
                <td>
                @if (Auth::check())
                    @if (Auth::user()->isAdmin == 1 || Auth::user()->id == $article->user_id)
                  <form action='{{ route('articles.edit', ['id' => $article->id]) }}' method="get">
                      <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                          <button type="submit" class="btn btn-success"> Edit </button>
                  </form>
                  @endif
              @endif
                  </td>
                  <td>
                  @if (Auth::check())
                      @if (Auth::user()->isAdmin == 1 || Auth::user()->id == $article->user_id)
                <form action='{{ route('articles.delete', ['id' => $article->id]) }}' method="post">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                      <button type="submit" class="btn btn-warning"> Delete </button>
                </form>
                @endif
            @endif
              </td>
              </tr>
            @endforeach
            </tbody>
          </table>
          {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection
