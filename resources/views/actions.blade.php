<div class="table-actions">

    <a href="{{ route('vig-reactions.edit', $item->id) }}" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-original-title="{{ trans('plugins/vig-reactions::vig-reactions.edit') }}"><i class="fa fa-edit"></i></a>

    <a href="#" class="btn btn-sm btn-icon btn-danger deleteDialog" data-bs-toggle="tooltip" data-section="{{ route('vig-reactions.destroy', $item->id) }}" role="button" data-bs-original-title="{{ trans('plugins/vig-reactions::vig-reactions.delete_entry') }}" >
        <i class="fa fa-trash"></i>
    </a>

    <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-warning" role="button" data-bs-original-title="{{ trans('plugins/vig-reactions::vig-reactions.copy') }}" onclick="event.preventDefault(); document.getElementById('copy-form-{{ $item->id }}').submit();">
        <i class="fa-solid fa-copy"></i>
    </a>

     <form id="copy-form-{{ $item->id }}" action="{{ route('vig-reactions.copy', $item->id) }}" method="POST" style="display: none;">
        @csrf
    </form>

</div>
