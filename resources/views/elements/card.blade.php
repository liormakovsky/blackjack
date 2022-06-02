<div class="col-md-2">
    <div class="card flex-1 m-1" style="background-color:#F5F5F5;min-height: 180px">
        <div class="card-body">
            {{$card->getShortName()}}
        </div>

        <div class="card-body text-center pb-1 pt-1">
            @if($card->getType() !== '?')
            <img src={{asset('images/'.$card->getType().'.png')}} style="height:40px;width:50px" alt="card-symbol"/>
            @else
            {{$card->getType()}}
            @endif
        </div>

        <div class="card-body text-right">
            {{$card->getShortName()}}
        </div>

    </div>
</div>
