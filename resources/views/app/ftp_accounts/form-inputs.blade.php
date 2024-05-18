@php $editing = isset($ftpAccount) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="username"
            label="Username"
            :value="old('username', ($editing ? $ftpAccount->username : ''))"
            maxlength="255"
            placeholder="Username"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.password
            name="password"
            label="Password"
            maxlength="255"
            placeholder="Password"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="web_app_id" label="Web App" required>
            @php $selected = old('web_app_id', ($editing ? $ftpAccount->web_app_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Web App</option>
            @foreach($webApps as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
