<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data" 
          x-data="{
              photoSrc: '{{ !empty($apiData['foto']) ? $apiData['foto'] : ($user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null) }}'
          }">
        @csrf
        @method('patch')

        <!-- Profile Photo Section (Display and Update) -->
        <div 
            class="col-span-12 flex flex-col items-center text-center"
        >
            <h3 class="text-lg font-medium text-gray-900">{{ __('Foto Profil') }}</h3>
            
            <!-- Photo Display -->
            <div class="mt-2">
                <!-- If there is a photo source (initial or preview), show the img tag -->
                <template x-if="photoSrc">
                    <img :src="photoSrc" alt="{{ $user->name }}" class="rounded-full h-28 w-28 object-cover">
                </template>
                
                <!-- If there is no photo source at all, show initials -->
                <template x-if="!photoSrc">
                    <x-initials-avatar :name="$user->name" class="h-28 w-28" />
                </template>
            </div>

            <!-- Photo Upload Controls -->
            <input type="file" class="hidden" x-ref="photo" name="photo"
                   @change="
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoSrc = e.target.result;
                        };
                        reader.readAsDataURL($event.target.files[0]);
                   ">

            <x-secondary-button class="mt-4" type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('Pilih Foto Baru') }}
            </x-secondary-button>

            <x-input-error for="photo" class="mt-2" />
        </div>

        <!-- Display API Data -->
        <div class="mt-8 border-t border-gray-200 pt-8">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Data Kepegawaian / Identitas') }}</h3>
            
            <div class="mt-4">
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                    <!-- Column 1 -->
                    <div class="space-y-6">
                        <!-- NIP/NIK Editable -->
                        <div>
                            <x-input-label for="nip" :value="__('NIP / NIK')" />
                            <x-text-input id="nip" name="nip" type="text" class="mt-1 block w-full" :value="old('nip', $user->nip)" autocomplete="nip" />
                            <x-input-error class="mt-2" :messages="$errors->get('nip')" />
                            <p class="mt-1 text-xs text-gray-500 italic">*Jika ASN, mohon masukkan NIP.</p>
                        </div>

                        @if (!empty($apiData))
                            <!-- Pangkat -->
                            @php
                                $pangkat = trim(($apiData['pangkat_nama'] ?? '') . ' ' . ($apiData['pangkat_golruang'] ?? ''));
                            @endphp
                            @if($pangkat && $pangkat !== '()')
                                <div>
                                    <x-input-label :value="__('Pangkat')" />
                                    <p class="mt-1 block w-full text-gray-700">{{ $pangkat }}</p>
                                </div>
                            @endif

                            <!-- Jabatan -->
                            @if(!empty($apiData['jabatan_nama']) && $apiData['jabatan_nama'] !== '-')
                                <div>
                                    <x-input-label :value="__('Jabatan')" />
                                    <p class="mt-1 block w-full text-gray-700">{{ $apiData['jabatan_nama'] }}</p>
                                </div>
                            @endif

                            <!-- Bidang -->
                            @if(!empty($apiData['jabatan_grup']) && $apiData['jabatan_grup'] !== '-' && !str_contains($apiData['jabatan_grup'], 'Hubungan Masyarakat'))
                                <div>
                                    <x-input-label :value="__('Unit Bagian')" />
                                    <p class="mt-1 block w-full text-gray-700">{{ $apiData['jabatan_grup'] }}</p>
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Column 2 -->
                    <div class="space-y-6">
                        @if (!empty($apiData))
                            <!-- Nama -->
                            @if(!empty($apiData['nama']) && $apiData['nama'] !== '-')
                                <div>
                                    <x-input-label :value="__('Nama')" />
                                    <p class="mt-1 block w-full text-gray-700 font-semibold">{{ $apiData['nama'] }}</p>
                                </div>
                            @endif

                            <!-- Unit Kerja -->
                            @if(!empty($apiData['unit_nama']))
                                <div>
                                    <x-input-label :value="__('Unit Kerja')" />
                                    <p class="mt-1 block w-full text-gray-700">{{ $apiData['unit_nama'] }}</p>
                                </div>
                            @endif

                            <!-- Nomor HP -->
                            @if(!empty($apiData['nomor_hp']) && $apiData['nomor_hp'] !== '-')
                                <div>
                                    <x-input-label :value="__('Nomor HP')" />
                                    <p class="mt-1 block w-full text-gray-700">{{ $apiData['nomor_hp'] }}</p>
                                </div>
                            @endif
                        @endif

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            @if (!empty($apiData['email']) && $apiData['email'] !== '-' && empty($user->email))
                                <p class="mt-1 block w-full text-gray-700">{{ $apiData['email'] }}</p>
                            @else
                                 <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                 <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                 <p class="mt-2 text-sm text-red-600">{{ __('Email dapat diperbarui.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Editable Information Section -->
        <div class="mt-8 border-t border-gray-200 pt-8">
             <h3 class="text-lg font-medium text-gray-900">{{ __('Informasi Tambahan') }}</h3>
            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8 mt-4">
                <!-- Facebook -->
                <div>
                    <x-input-label for="facebook" :value="__('Facebook')" />
                    <div class="flex items-center mt-1">
                        <span class="inline-flex items-center px-3 text-gray-500 bg-gray-50 border border-r-0 border-gray-300 rounded-l-md h-10">
                            <i class="bi bi-facebook w-5 h-5"></i>
                        </span>
                        <x-text-input id="facebook" name="facebook" type="text" class="rounded-none rounded-r-md block w-full" :value="old('facebook', $user->facebook)" autocomplete="facebook" placeholder="https://facebook.com/username" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('facebook')" />
                </div>

                <!-- Instagram -->
                <div>
                    <x-input-label for="instagram" :value="__('Instagram')" />
                     <div class="flex items-center mt-1">
                        <span class="inline-flex items-center px-3 text-gray-500 bg-gray-50 border border-r-0 border-gray-300 rounded-l-md h-10">
                           <i class="bi bi-instagram w-5 h-5"></i>
                        </span>
                        <x-text-input id="instagram" name="instagram" type="text" class="rounded-none rounded-r-md block w-full" :value="old('instagram', $user->instagram)" autocomplete="instagram" placeholder="https://instagram.com/username" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('instagram')" />
                </div>

                <!-- TikTok -->
                <div>
                    <x-input-label for="tiktok" :value="__('Tiktok')" />
                    <div class="flex items-center mt-1">
                        <span class="inline-flex items-center px-3 text-gray-500 bg-gray-50 border border-r-0 border-gray-300 rounded-l-md h-10">
                            <i class="bi bi-tiktok w-5 h-5"></i>
                        </span>
                        <x-text-input id="tiktok" name="tiktok" type="text" class="rounded-none rounded-r-md block w-full" :value="old('tiktok', $user->tiktok)" autocomplete="tiktok" placeholder="https://tiktok.com/@username" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('tiktok')" />
                </div>

                <!-- LinkedIn -->
                <div>
                    <x-input-label for="linkedin" :value="__('LinkedIn')" />
                    <div class="flex items-center mt-1">
                        <span class="inline-flex items-center px-3 text-gray-500 bg-gray-50 border border-r-0 border-gray-300 rounded-l-md h-10">
                            <i class="bi bi-linkedin w-5 h-5"></i>
                        </span>
                        <x-text-input id="linkedin" name="linkedin" type="text" class="rounded-none rounded-r-md block w-full" :value="old('linkedin', $user->linkedin)" autocomplete="linkedin" placeholder="https://linkedin.com/in/username" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('linkedin')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @elseif (session('status') === 'email-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Email berhasil diperbarui.') }}</p>
            @endif
        </div>
    </form>
</section>