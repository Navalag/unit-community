<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div class="card mb-3" id="reply-{{ $reply->id }}">
        <div class="card-header">
            <div class="level">
                <h6 class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}
                </h6>
                <div>
                    <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                        {{ csrf_field() }}

                        <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }} {{ Str::plural('favorite', $reply->favorites_count) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea v-model="body" name="" id="" class="form-control" cols="" rows=""></textarea>
                </div>

                <button class="btn btn-primary btn-sm" @click="update">Update</button>
                <button class="btn btn-link btn-sm" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        {{--    TODO: ned to fix code below--}}
        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn btn-secondary btn-sm mr-1" @click="editing = true">Edit</button>

                <form method="POST" action="/replies/{{ $reply->id}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</reply>
