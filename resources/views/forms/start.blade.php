<div class="container">
    <div class="row justify-content-center">
        <form method="POST" action="{{ route('blackjack.start') }}">
            @csrf
            <div class="form-group">
                <label for="name">Player Name</label>
                <input type="text" class="form-control" id="name" name="name">
                @if($errors->has('name'))
                    {{$errors->first('name')}}
                @endif
            </div>
            <button class="btn btn-primary" role="button">Start New Game</button>
        </form>
    </div>
</div>
