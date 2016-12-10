<div class="x_panel">
    <div class="pull-right">
        @if(!empty($table->show_toolbar['view']))
            <button onclick="findRoute('view');" class="btn btn-dark" type="button">
                {{$table->show_toolbar['view']}}
            </button>
        @endif
        @if(!empty($table->show_toolbar['add']))
            <button onclick="findRoute('add');" class="btn btn-success" type="button">
                {{$table->show_toolbar['add']}}
            </button>
        @endif
        @if(\Input::has('filter_trashed'))
            @if(!empty($table->show_toolbar['restore']))
                <button onclick="findAction('restore');" class="btn btn-warning " type="button">
                    {{$table->show_toolbar['restore']}}
                </button>
            @endif
            @if(!empty($table->show_toolbar['forcedelete']))
                <button onclick="findAction('forcedelete');" class="btn btn-danger" type="button">
                    {{$table->show_toolbar['forcedelete']}}
                </button>
            @endif
        @else
            @if(!empty($table->show_toolbar['edit']))
                <button onclick="findRoute('edit');" class="btn btn-primary" type="button">
                    {{$table->show_toolbar['edit']}}
                </button>
            @endif
            @if(!empty($table->show_toolbar['publish']))
                <button onclick="findAction('enable');" class="btn btn-info" type="button">
                    {{$table->show_toolbar['publish']}}
                </button>
            @endif
            @if(!empty($table->show_toolbar['unpublish']))
                <button onclick="findAction('disable');" class="btn btn-warning " type="button">
                    {{$table->show_toolbar['unpublish']}}
                </button>
            @endif
            @if(!empty($table->show_toolbar['trash']))
                <button onclick="findAction('remove');" class="btn btn-danger" type="button">
                    {{$table->show_toolbar['trash']}}
                </button>
            @endif
        @endif
    </div>
</div>
