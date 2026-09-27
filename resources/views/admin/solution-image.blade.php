@if(!empty($details['display_image_url']))
    <img src="{{ $details['display_image_url'] }}" alt="{{ $details['title'] ?? 'Solution image' }}" class="h-48 w-full object-cover" loading="lazy" referrerpolicy="no-referrer">
@else
    @php($photo = (int) ($details['photo'] ?? 0))
    <div class="h-48 w-full" role="img" aria-label="{{ $details['title'] ?? 'Default solution image' }}" style="background-image: url('{{ asset('images/solutions/activities.png') }}'); background-repeat: no-repeat; background-size: 400% auto; background-position: {{ ($photo % 4) * 100 / 3 }}% {{ $photo < 4 ? 6 : 62 }}%;"></div>
@endif
