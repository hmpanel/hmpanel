@php $editing = isset($emailAccount) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $emailAccount->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.email>
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
            @php $selected = old('web_app_id', ($editing ? $emailAccount->web_app_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Web App</option>
            @foreach($webApps as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
