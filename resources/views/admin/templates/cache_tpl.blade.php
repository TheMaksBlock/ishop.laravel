<p class="item-p">
    <a class="list-group-item">{{ $value }}</a>
    <span>
        <a href="{{ route($path, ["k"=>$key]) }}" class="delete">
            <i class="fa fa-fw fa-close text-danger"></i>
        </a>
    </span>
</p>
