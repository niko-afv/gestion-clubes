


<!--
    Clubs List
-->
@if(isset($club))
    <button onclick="window.location.replace('{{ route('club_detail',['club'=>$club->id]) }}');" title="Ver Club" class="btn btn-primary" type="button"><i class="fa fa-eye"></i>&nbsp; </button>
@endif
@can('sync-data')
    @if(isset($club))
        <button data-url="{{ route('club_sync',['club'=>$club->id]) }}" title="Sincronizar Club" class="btn btn-primary club_sync" type="button"><i class="fa fa-repeat"></i>&nbsp; </button>
    @endif
@endif


<!--
    Club Detail
-->
@can('crud-club-members')
    @if( isset($member) )
    <a style="color: #1c84c6; display: inline-block; width: 20%;" href="{{ route('edit_member', $member->id) }}" class="btn btn-outline btn-link" title="Modificar Miembro"><i class="fa fa-edit"></i></a>
    @endif
@endcan

@can('add-club-director')
    @if( isset($member) &&  !$member->isDirector() )
        <a style="color: #1c84c6; display: inline-block; width: 20%;"
           data-url="{{ route('set_as_director', [$club->id, $member->id] ) }}"
           class="btn btn-outline btn-link set-director"
           title="Convertir en director">
            <i class="fa fa-bolt"></i>
        </a>
    @endif
@endcan