<div class="mt-5 md:mt-0 md:col-span-2">

    <div>
        <x-modal.form-modal wire:model="openThisModal">
            <x-slot name="title">
                <span class="text-bh-red-600">
                    Duplicate Participants for this trip
                </span>
                <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                    Please remove the participants listed below as they are already registered for this trip.
                </p>
                <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                    Once this is completed you may continue to add new participants.
                </p>
            </x-slot>

            <x-slot name="content">
                <ul class="font-normal text-{{ $destination->country->color }}-800 list-inside list-disc">
                    @foreach ($this->guestAlreadyGoing as $index => $guestGoing)
                        <li>
                            {{$guestGoing['first_name'] . ' ' . $guestGoing['last_name']}}
                        </li>
                    @endforeach
                </ul>

            </x-slot>

            <x-slot name="footer">
                <button
                    class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-bh-red-600 hover:bg-bh-red-500 focus:outline-none focus:border-bh-red-700 focus:ring-blue active:bg-bh-red-700 transition duration-150 ease-in-out"
                    wire:click="closeThisModal"
                    wire:loading.attr="disabled">
                    Okay got it
                </button>
            </x-slot>
        </x-modal.form-modal>
        <x-modal.form-modal wire:model="openThisModalSameEmailMain">
            <x-slot name="title">
                <span class="text-bh-red-600">
                    Duplicate Emails Detected
                </span>
            </x-slot>

            <x-slot name="content">
                <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                    Emails cannot be the same as the main member's email.
                </p>
                <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                    Please change the duplicate email addresses to a unique email address, or leave it blank.
                </p>
            </x-slot>

            <x-slot name="footer">
                <button
                    class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-bh-red-600 hover:bg-bh-red-500 focus:outline-none focus:border-bh-red-700 focus:ring-blue active:bg-bh-red-700 transition duration-150 ease-in-out"
                    wire:click="closeThisModal"
                    wire:loading.attr="disabled">
                    Okay got it
                </button>
            </x-slot>
        </x-modal.form-modal>
        <x-modal.form-modal wire:model="openThisModalSameEmail">
            <x-slot name="title">
                <span class="text-bh-red-600">
                    Duplicate Emails Detected
                </span>
            </x-slot>

            <x-slot name="content">
                <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                    All guest members must have unique emails.
                </p>
                <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                    Please change the duplicate email addresses to a unique email address, or leave it blank.
                </p>
            </x-slot>

            <x-slot name="footer">
                <button
                    class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-bh-red-600 hover:bg-bh-red-500 focus:outline-none focus:border-bh-red-700 focus:ring-blue active:bg-bh-red-700 transition duration-150 ease-in-out"
                    wire:click="closeThisModal"
                    wire:loading.attr="disabled">
                    Okay got it
                </button>
            </x-slot>
        </x-modal.form-modal>
        <x-modal.form-modal :noLeaving="true" wire:model="alreadyOnTrip">
            <x-slot name="title">
        <span class="text-bh-red-600">
            Looks like you're already on this trip!
        </span>
            </x-slot>

            <x-slot name="content">
                @if($foundUser)
                    @if($verifyDobMatch === null)
                        <div class="space-y-4">
                            <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                                A reservation for this trip already exists under "{{ $foundUser->fullName }}"with the
                                email: {{ $foundUser->maskedEmail() }}.
                            </p>
                            <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                                If this is you, log out and sign in with the associated email.
                            </p>
                            <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                                If not, verify your date of birth to continue.
                            </p>
                            <div class="mt-1 relative rounded-md shadow-sm my-4">
                                <label for="state.trip_participant_one_dob"
                                       class="block text-sm font-medium leading-5 text-{{ $destination->country->color }}-800">
                                    Verify Date of Birth:
                                </label>
                                <input
                                    class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-0 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5 {{ $errors->has('state.trip_participant_one_dob') ? 'border-red-500' : '' }}"
                                    id="state.trip_participant_one_dob"
                                    type="date" wire:model="state.trip_participant_one_dob"/>
                            </div>
                            @error('state.trip_participant_one_dob') <p
                                class="text-bh-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    @elseif($verifyDobMatch === true)
                        <div class="space-y-4">
                            <p class="font-bold text-lg text-bh-red-600">
                                Date of birth matched!
                            </p>
                            <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                                The date of birth matched the reservation for "{{ $foundUser->fullName }}" at
                                email: {{ $foundUser->maskedEmail() }}.
                            </p>
                            <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                                Please log out and sign in with the email used for this reservation.
                            </p>
                        </div>
                    @else
                        <div class="space-y-4">
                            <p class="font-bold text-lg text-gray-600">
                                Date of birth did not match!
                            </p>
                            <p class="text-{{ $destination->country->color }}-800 text-sm font-normal">
                                Since the date of birth did not match you can continue with the reservation process.
                            </p>
                        </div>
                    @endif

                    <p class="pt-4 text-{{ $destination->country->color }}-800 text-sm font-normal">
                        If you need further assistance, please contact us at<br class="md:block hidden"/> 833-265-3467
                        ext: 705 or email our <a href="mailto:rachel@boldhope.org" class="text-bh-red-600">Trip
                            Coordinator</a>.
                    </p>
                @endif
            </x-slot>

            <x-slot name="footer">
                @if($verifyDobMatch === null)
                    <button
                        class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-bh-red-600 hover:bg-bh-red-500 focus:outline-none focus:border-bh-red-700 focus:ring-blue active:bg-bh-red-700 transition duration-150 ease-in-out"
                        wire:click="verifyDob"
                        wire:loading.attr="disabled">
                        Verify DOB
                    </button>
                @elseif($verifyDobMatch === true)
                    <p class="inline-flex justify-center py-2 px-4 text-lg leading-5 font-black text-gray-600">
                        Cannot continue, as you are already on this trip.
                    </p>
                    <button wire:click="logoutAndContinue"
                            class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-bh-red-600 hover:bg-bh-red-500 focus:outline-none focus:border-bh-red-700 focus:ring-blue active:bg-bh-red-700 transition duration-150 ease-in-out">
                        Logout
                    </button>

                @else
                    <button
                        class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-bh-red-600 hover:bg-bh-red-500 focus:outline-none focus:border-bh-red-700 focus:ring-blue active:bg-bh-red-700 transition duration-150 ease-in-out"
                        wire:click="closeThisModal"
                        wire:loading.attr="disabled">
                        Continue Reservation
                    </button>
                @endif
            </x-slot>
        </x-modal.form-modal>
    </div>

    <div class="bg-white overflow-hidden shadow-2xl rounded-lg relative">
        <div class="absolute top-0 right-0 px-2.5 py-0.5 rounded-bl-lg bg-bh-green-100">
            <p class="inline-flex items-center text-xs font-medium text-bh-green-800">
                Use this form to reserve your trip.
            </p>
        </div>
        <div>
            <div class="px-4 py-4 sm:px-6 md:grid md:grid-cols-2 gap-2 md:flex items-center justify-center">
                <h4 class="col-span-2 pl-0 md:pb-0 pb-4 block text-sm font-medium leading-5 text-gray-700">
                    <span class="font-bold">
                        {{ $this->state['reservation_type'] === 'minor_signup' ? 'Guardian Of Participants' : ($this->state['reservation_type'] === 'family_signup' ? 'Main Trip Participant' : 'Main Trip Participant') }}
                    </span>
                    <span class="block flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4 inline-block stroke-current text-{{ $destination->country->color }}-600"
                                 fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            You're financially responsible for all members you are signing up.
                        </span>
                </h4>

                <div class="col-span-1 md:py-0 py-2">
                    <label for="state.trip_participant_one_first_name"
                           class="block text-sm font-medium leading-5 text-gray-700">
                        {{ ($this->state['reservation_type'] === 'minor_signup' ? 'Guardian' : 'Main Trip Participant') . ' First Name' }}
                        <x-required-dot/>
                    </label>

                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="state.trip_participant_one_first_name"
                               class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-0 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5 bg-gray-100 cursor-not-allowed"
                               readonly
                               type="text" wire:model.defer="state.trip_participant_one_first_name"/>
                    </div>
                    @error('state.trip_participant_one_first_name')
                    <span class="text-xs text-red-500">
                                        {{ $message }}
                                    </span>
                    @enderror
                </div>
                <div class="col-span-1 md:py-0 py-2">
                    <label for="state.trip_participant_one_last_name"
                           class="block text-sm font-medium leading-5 text-gray-700">
                        {{ ($this->state['reservation_type'] === 'minor_signup' ? 'Guardian' : 'Main Trip Participant') . ' Last Name' }}

                        <x-required-dot/>
                    </label>

                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input
                            class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-0 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5 bg-gray-100 cursor-not-allowed"
                            readonly
                            id="state.trip_participant_one_last_name"
                            type="text" wire:model="state.trip_participant_one_last_name"/>
                    </div>
                    @error('state.trip_participant_one_last_name')
                    <span class="text-xs text-red-500">
                                        {{ $message }}
                                    </span>
                    @enderror
                </div>
                <div class="col-span-1 md:py-0 py-2">
                    <label for="state.trip_participant_one_email"
                           class="block text-sm font-medium leading-5 text-gray-700">
                        {{ ($this->state['reservation_type'] === 'minor_signup' ? 'Guardian' : 'Main Trip Participant') . ' Email' }}
                        <x-required-dot/>
                    </label>

                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input
                            class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-0 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5 bg-gray-100 cursor-not-allowed"
                            readonly
                            id="state.trip_participant_one_email"
                            type="email" wire:model="state.trip_participant_one_email"/>
                    </div>
                    @error('state.trip_participant_one_email')
                    <span class="text-xs text-red-500">
                                        {{ $message }}
                                    </span>
                    @enderror
                </div>
                <div class="col-span-1 md:py-0 py-2">
                    <label for="state.trip_participant_one_dob"
                           class="block text-sm font-medium leading-5 text-gray-700">
                        {{ ($this->state['reservation_type'] === 'minor_signup' ? 'Guardian' : 'Main Trip Participant') . ' Date Of Birth' }}
                        <x-required-dot/>
                    </label>

                    @if(isset($user->dob))
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input
                                class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-0 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5 bg-gray-100 cursor-not-allowed"
                                readonly
                                id="state.trip_participant_one_dob"
                                type="date" wire:model="state.trip_participant_one_dob"/>
                        </div>
                    @else
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input
                                class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-0 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5"
                                id="state.trip_participant_one_dob"
                                type="date" wire:model="state.trip_participant_one_dob"/>
                        </div>
                    @endif
                    @error('state.trip_participant_one_dob')
                    <span class="text-xs text-red-500">
                                        {{ $message }}
                                    </span>
                    @enderror
                </div>

            </div>
        </div>

        @if($this->state['reservation_type'] === 'family_signup' || $this->state['reservation_type'] === 'minor_signup')
            @if(isset($this->currentGuests))
                @if($this->currentGuests->count() >= 1)
                    <div class="px-6 py-2">
                        <div class="col-span-2">
                            <h4 class="col-span-2 pl-0 block text-sm font-medium leading-5 text-gray-700">
                                <span class="font-bold">You want to bring past family members?</span>
                                <span class="block flex items-center">
                            Select the members you would like to bring.
                        </span>
                            </h4>
                            <div class="mt-4 border-t border-b border-gray-200 divide-y divide-gray-200">
                                @foreach($this->currentGuests as $i => $guest)
                                    <div class="relative flex items-start py-4">
                                        <div class="min-w-0 flex-1 text-sm">
                                            <label for="{{ $guest->salesforce_id }}"
                                                   class="font-medium text-gray-700 select-none">
                                                {{ $guest->guestOrUserFullName() }}
                                            </label>
                                        </div>
                                        <div class="ml-3 flex items-center h-5">
                                            <input
                                                wire:model="state.current_guests.{{ $i }}"
                                                name="selection[]" value="{{ $guest->salesforce_id }}"
                                                type="checkbox"
                                                id="{{ $guest->salesforce_id }}"
                                                class="focus:ring-{{ $destination->country->color }}-500 h-4 w-4 text-{{ $destination->country->color }}-600 border-{{ $destination->country->color }}-300 rounded">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <div class="px-6 py-2">
                <div
                    class="bg-{{ $destination->country->color }}-100 px-4 py-4 sm:px-6 grid grid-cols-2 md:grid-cols-3 gap-2 flex items-center justify-center rounded-md">
                    <div class="col-span-1 md:col-span-2">
                        <p class="text-sm font-bold text-gray-700">
                            Use the counter to add
                            {{ $this->state['reservation_type'] === 'minor_signup' ? 'minors:' : ($this->state['reservation_type'] === 'family_signup' ? 'family members:' : '') }}

                        </p>
                    </div>
                    <div class="col-span-1">
                        <div class="relative flex justify-end">
                            <div class="relative inline-flex shadow-sm rounded-md">
                                <button wire:click="$emit('incrementDecrement', 'decrement')"
                                        @if($state['family_participant_count'] == 0)
                                            disabled
                                        @endif
                                        class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-{{ $destination->country->color }}-500 focus:border-{{ $destination->country->color }}-500">
                                    <svg class="w-4 h-4 stroke-current text-gray-600" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <button wire:click="$emit('incrementDecrement', 'increment')"
                                        class="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-{{ $destination->country->color }}-500 focus:border-{{ $destination->country->color }}-500">
                                    <svg class="w-4 h-4 stroke-current text-gray-600" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @error('state.family_participant_count')
                <p class="mt-1 text-sm italic text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($state['family_participant_count'] === 0)
                <div class="block pb-6"></div>
            @endif
            <!--LOOP-->
            <div class="col-span-6 divide-dashed divide-y divide-{{ $destination->country->color }}-200 px-4 sm:px-6">
                {{--                @for($i = 0 ; $i < min(100, count($state['trip_participant_id'])); $i++)--}}
                @foreach($state['trip_participant_id'] as $i => $tripParticipant)
                    <div class="py-6">
                        <h4 class="pl-0 block text-sm font-bold leading-5 text-gray-700 pb-2">Trip
                            Participant {{ $this->state['reservation_type'] === 'minor_signup' ? $i+1 : ($this->state['reservation_type'] === 'family_signup' ? $i+2 : $i) }}
                        </h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <label for="state.trip_participant_first_name.{{ $i }}"
                                       class="block text-sm font-medium leading-5 text-gray-700">Trip
                                    Participant {{ $this->state['reservation_type'] === 'minor_signup' ? $i+1 : ($this->state['reservation_type'] === 'family_signup' ? $i+2 : $i) }}
                                    First Name
                                    <x-required-dot/>
                                </label>

                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input
                                        class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-50 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5"
                                        id="state.trip_participant_first_name.{{ $i }}"
                                        autocomplete="given-name"
                                        type="text" min="80"
                                        wire:model.defer="state.trip_participant_first_name.{{ $i }}"
                                        placeholder="Enter First Name"/>
                                </div>
                                @error('state.trip_participant_first_name.'.$i)
                                <span class="text-xs text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-span-1">
                                <label for="state.trip_participant_last_name.{{ $i }}"
                                       class="block text-sm font-medium leading-5 text-gray-700">Trip
                                    Participant {{ $this->state['reservation_type'] === 'minor_signup' ? $i+1 : ($this->state['reservation_type'] === 'family_signup' ? $i+2 : $i) }}
                                    Last Name
                                    <x-required-dot/>
                                </label>

                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input
                                        class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-50 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5"
                                        id="state.trip_participant_last_name.{{ $i }}"
                                        type="text" min="80"
                                        wire:model.lazy="state.trip_participant_last_name.{{ $i }}"
                                        placeholder="Enter Last Name"/>
                                </div>
                                @error('state.trip_participant_last_name.'.$i)
                                <span class="text-xs text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror
                                @if(!$state['trip_participant_last_name'][$i])
                                @elseif($state['trip_participant_last_name'][$i] !== $state['trip_participant_one_last_name'])
                                    <span class="text-xs text-bh-orange-600">
                                        The last name is not the same as the rest of the family. This participant will be added to your family.
                                    </span>
                                @endif
                            </div>
                            <div class="col-span-1">
                                <label for="state.trip_participant_email.{{ $i }}"
                                       class="block text-sm font-medium leading-5 text-gray-700">Trip
                                    Participant {{ $this->state['reservation_type'] === 'minor_signup' ? $i+1 : ($this->state['reservation_type'] === 'family_signup' ? $i+2 : $i) }}
                                    Email</label>

                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input
                                        class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-50 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5"
                                        id="state.trip_participant_email.{{ $i }}"
                                        type="email" min="191" wire:model="state.trip_participant_email.{{ $i }}"
                                        placeholder="Enter Email: Optional"/>
                                </div>


                                @error('state.trip_participant_email.'.$i)
                                <span class="text-xs text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>
                            <div class="col-span-1">
                                <label for="state.trip_participant_dob.{{ $i }}"
                                       class="block text-sm font-medium leading-5 text-gray-700">Trip
                                    Participant {{ $this->state['reservation_type'] === 'minor_signup' ? $i+1 : ($this->state['reservation_type'] === 'family_signup' ? $i+2 : $i) }}
                                    Date of birth
                                    <x-required-dot/>
                                </label>

                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input
                                        class="mt-1 focus:border-{{ $destination->country->color }}-300 focus:ring focus:ring-{{ $destination->country->color }}-200 focus:ring-opacity-50 block w-full shadow-sm sm:text-sm border-{{ $destination->country->color }}-300 rounded-md sm:text-sm sm:leading-5"
                                        id="state.trip_participant_dob.{{ $i }}"
                                        type="date" wire:model="state.trip_participant_dob.{{ $i }}"
                                        placeholder="Enter Birthdate"/>
                                </div>
                                @error('state.trip_participant_dob.'.$i)
                                <span class="text-xs text-red-500">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!--LOOP-->
        @endif
        <div class="bg-gray-100 border-t border-gray-200">
            <div class="px-4 py-3 bg-gray-50 sm:px-6 flex justify-between items-center">
                <div class="flex justify-start">
                    @if($this->state['showPaymentForm'])
                        <div class="flex-1">
                            <h4 class="text-xl capitalize mt-2 leading-9 font-extrabold text-gray-600">
                                <span>Total Amount: ${{ number_format($this->state['amount'] / 100, 2) }}</span>
                            </h4>
                            <p class="block italic text-xs">This is non-refundable and non-tax-deductible.</p>
                        </div>
                    @endif
                </div>
                <div class="flex justify-end">
                    <button wire:click.prevent="$emit('goToStep', '{{ $this->previous }}')" type="button"
                            class="mr-4 inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-transparent hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bg-gray-200">
                        Previous
                    </button>
                    @if($foundUser && $verifyDobMatch === true)
                        <div type="button"
                             class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-{{ $destination->country->color }}-300">
                            Cannot Continue
                        </div>
                    @elseif($foundUserContinue === true || !$foundUser)
                        <button type="button"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-{{ $destination->country->color }}-600 hover:bg-{{ $destination->country->color }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $destination->country->color }}-500"
                                @if($state['family_participant_count'] < 0) disabled @endif
                                wire:click="emailMainChecks">
                            Continue
                        </button>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
