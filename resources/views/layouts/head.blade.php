<div class="col-lg-10">
    <h2>{{ $breadcrumb->last() }}</h2>
    @if(isset($breadcrumb))
        <ol class="breadcrumb">
            @foreach($breadcrumb as $url => $title)
                @if( $url != 'active' )
                    <li class="breadcrumb-item">
                        <a href="{{ $url }}">{{ $title }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item active">
                        <strong>{{ $title }}</strong>
                    </li>
                @endif
            @endforeach

        </ol>
    @endif
</div>