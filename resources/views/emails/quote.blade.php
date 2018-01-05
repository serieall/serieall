@component('vendor::mail::message')
    {{-- Greeting --}}
    @if (! empty($greeting))
        # {{ $greeting }}
    @else
        @if ($level == 'error')
            # Whoops !
        @else
            # Salut !
        @endif
    @endif

    {{-- Intro Lines --}}
    @foreach ($introLines as $line)
        {{ $line }}

    @endforeach

    <blockquote class="ui message">
        {{ $quote }}
    </blockquote>

    {{-- Action Button --}}
    @isset($actionText)
        <?php
        switch ($level) {
            case 'success':
                $color = 'green';
                break;
            case 'error':
                $color = 'red';
                break;
            default:
                $color = 'blue';
        }
        ?>
        @component('vendor::mail::button', ['url' => $actionUrl, 'color' => $color])
            {{ $actionText }}
        @endcomponent
    @endisset

    {{-- Outro Lines --}}
    @foreach ($outroLines as $line)
        {{ $line }}

    @endforeach

    {{-- Salutation --}}
    @if (! empty($salutation))
        {{ $salutation }}
    @else
        A bientôt,<br>{{ config('app.name') }}
    @endif

    {{-- Subcopy --}}
    @isset($actionText)
        @component('vendor::mail::subcopy')
            Si vous avez des soucis en cliquant sur le boutoun "{{ $actionText }}", copiez-collez l'URL ci-dessous dans votre navigateur web : [{{ $actionUrl }}]({{ $actionUrl }})
        @endcomponent
    @endisset
@endcomponent