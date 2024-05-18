@php $editing = isset($webApp) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $webApp->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="path"
            label="Path"
            :value="old('path', ($editing ? $webApp->path : ''))"
            maxlength="255"
            placeholder="Path"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="domain_id" label="Domain" required>
            @php $selected = old('domain_id', ($editing ? $webApp->domain_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Domain</option>
            @foreach($domains as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
