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
            name="username"
            label="Username"
            :value="old('username', ($editing ? $webApp->username : ''))"
            maxlength="255"
            placeholder="Username"
            required
        ></x-inputs.text>
    </x-inputs.group>



    <x-inputs.group class="w-full">
        <x-inputs.text
            name="password"
            label="Password"
            :value="old('password', ($editing ? $webApp->password : ''))"
            maxlength="255"
            placeholder="Password"
            required
        ></x-inputs.text>
    </x-inputs.group>


    <x-inputs.group class="w-full">
        <x-inputs.text
            name="database"
            label="Database"
            :value="old('database', ($editing ? $webApp->database : ''))"
            maxlength="255"
            placeholder="Database"
            required
        ></x-inputs.text>
    </x-inputs.group>


    <x-inputs.group class="w-full">
        <x-inputs.text
            name="basepath"
            label="Basepath"
            :value="old('basepath', ($editing ? $webApp->basepath : ''))"
            maxlength="255"
            placeholder="Basepath"
            required
        ></x-inputs.text>
    </x-inputs.group>

 
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="php"
            label="Php"
            :value="old('php', ($editing ? $webApp->php : ''))"
            maxlength="255"
            placeholder="Php"
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
