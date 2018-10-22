<form action="{{ $route }}" class="ui inline form" method="post" >
    {{ csrf_field() }}

    <input type="hidden" name="_method" value="DELETE">

    <button class="{{ $type }} negative ui button" title="{{ $title }}" value="{{ $title }}" onclick="return confirm('{{ $title }}')">
        {{ $slot }}
    </button>
</form>