<div>
    <p>{{ $user->name }}</p>
    @if($isOnline)
        <span class="text-green-500">Online</span>
    @else
        <span class="text-gray-500">Last seen: {{ $lastSeen }}</span>
    @endif
</div>
