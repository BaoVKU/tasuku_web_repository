<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Profile Information') }}
                            </h2>
                        </header>

                        <div class="mt-6 space-y-6">
                            <div class="flex justify-center sm:justify-start">
                                <label for="avatar" class="block border w-48 h-48 rounded-full relative group p-1">
                                    <img src="{{ asset($user->avatar) }}" alt="user avatar"
                                        class="w-full h-full rounded-full object-cover object-center">
                                </label>
                            </div>
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="$user->name" :disabled="true" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="$user->email" :disabled="true" />
                            </div>

                            <div>
                                <x-input-label for="phone_number" :value="__('Phone Number')" />
                                <x-text-input id="phone_number" name="phone_number" type="text"
                                    class="mt-1 block w-full" :value="$user->phone_number" :disabled="true" />
                            </div>

                            <div>
                                <x-input-label for="birthday" :value="__('Birthday')" />
                                <x-text-input id="birthday" name="birthday" type="date" class="mt-1 block"
                                    :value="$user->birthday" :disabled="true" />
                            </div>

                            <div>
                                <x-input-label for="gender" :value="__('Gender')" />
                                <x-text-input id="gender" name="gender" type="text" class="mt-1 block w-full"
                                    :value="$user->gender" :disabled="true" />
                            </div>

                            <div>
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                    :value="$user->address" :disabled="true" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <x-textarea-input id="description" name="description" rows="6"
                                    class="mt-1 block w-full" disabled>{{ $user->description }}</x-textarea-input>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
