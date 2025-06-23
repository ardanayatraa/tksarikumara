<div>
    <x-dialog-modal wire:model="open" max-width="2xl">
        <x-slot name="title">Edit Nilai Siswa</x-slot>

        <x-slot name="content">
            {{-- Hidden keys --}}
            <input type="hidden" wire:model="id_nilai" />
            <input type="hidden" wire:model="id_penilaian" />
            <input type="hidden" wire:model="id_akunsiswa" />
            <input type="hidden" wire:model="id_guru" />

            {{-- Pilih Kelas & Tanggal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div>
                        <x-dialog-modal wire:model="open" max-width="2xl">
                            <x-slot name="title">Edit Nilai Siswa</x-slot>

                            <x-slot name="content">
                                {{-- Hidden keys --}}
                                <input type="hidden" wire:model="id_nilai" />
                                <input type="hidden" wire:model="id_penilaian" />
                                <input type="hidden" wire:model="id_akunsiswa" />
                                <input type="hidden" wire:model="id_guru" />

                                {{-- Pilih Kelas & Tanggal --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-label for="id_kelas" value="Kelas" />
                                        <select id="id_kelas" disabled wire:model.defer="id_kelas"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            @foreach ($kelasList as $k)
                                                <option value="{{ $k->id_kelas }}">{{ $k->namaKelas }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_kelas')
                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <x-label for="tgl_penilaian" value="Tanggal Penilaian" />
                                        <x-input id="tgl_penilaian" type="date" wire:model.defer="tgl_penilaian"
                                            class="mt-1 block w-full" />
                                        @error('tgl_penilaian')
                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-4">

                                {{-- Pilih Indikator --}}
                                <div class="mb-4">
                                    <x-label for="indikator_aspek_id" value="Pilih Indikator" />
                                    <select id="indikator_aspek_id" wire:model.defer="indikator_aspek_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">— Pilih Indikator —</option>
                                        @foreach ($aspekGroups as $asp)
                                            <optgroup label="{{ $asp->kode_aspek }}. {{ $asp->nama_aspek }}">
                                                @foreach ($asp->indikator as $ind)
                                                    <option value="{{ $ind->id }}">
                                                        {{ $ind->kode_indikator }}. {{ $ind->nama_indikator }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('indikator_aspek_id')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Nilai & Skor --}}
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <x-label for="nilai" value="Nilai" />
                                        <select id="nilai" wire:model.live="nilai"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="">— Pilih Nilai —</option>
                                            <option value="BSB">BSB – Berkembang Sangat Baik</option>
                                            <option value="BSH">BSH – Berkembang Sesuai Harapan</option>
                                            <option value="MB">MB – Mulai Berkembang</option>
                                            <option value="BB">BB – Belum Berkembang</option>
                                        </select>
                                        @error('nilai')
                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <x-label for="skor" value="Skor" />
                                        <x-input id="skor" type="text" disabled wire:model.defer="skor"
                                            class="mt-1 block w-full bg-gray-100 cursor-not-allowed" />
                                        @error('skor')
                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Catatan --}}
                                <div class="mb-4">
                                    <x-label for="catatan" value="Catatan (opsional)" />
                                    <textarea id="catatan" wire:model.defer="catatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        rows="3"></textarea>
                                </div>
                            </x-slot>

                            <x-slot name="footer">
                                <x-button wire:click="update">Update</x-button>
                                <x-secondary-button wire:click="$set('open', false)"
                                    class="ml-2">Batal</x-secondary-button>
                            </x-slot>
                        </x-dialog-modal>
                    </div>

                    <x-label for="id_kelas" value="Kelas" />
                    <select id="id_kelas" disabled wire:model.defer="id_kelas"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">— Pilih Kelas —</option>
                        @foreach ($kelasList as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->namaKelas }}</option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label for="tgl_penilaian" value="Tanggal Penilaian" />
                    <x-input id="tgl_penilaian" type="date" wire:model.defer="tgl_penilaian"
                        class="mt-1 block w-full" />
                    @error('tgl_penilaian')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <hr class="my-4">

            {{-- Pilih Aspek (Parent → Child) --}}
            <div class="space-y-4">
                <div>
                    <x-label for="id_aspek" value="Aspek Penilaian" />
                    <select id="id_aspek" wire:model.defer="id_aspek"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">— Pilih Aspek —</option>
                        @foreach ($aspekGroups as $parent)
                            <optgroup label="{{ $parent->kode_aspek }}. {{ $parent->nama_aspek }}">
                                @forelse($parent->children as $child)
                                    <option value="{{ $child->id_aspek }}">
                                        {{ $child->kode_aspek }}. {{ $child->nama_aspek }}
                                    </option>
                                @empty
                                    <option value="{{ $parent->id_aspek }}">
                                        {{ $parent->kode_aspek }}. {{ $parent->nama_aspek }}
                                    </option>
                                @endforelse
                            </optgroup>
                        @endforeach
                    </select>
                    @error('id_aspek')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Nilai & Skor --}}
                <div>
                    <x-label for="nilai" value="Nilai" />
                    <select id="nilai" wire:model.live="nilai"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">— Pilih Nilai —</option>
                        <option value="BSB">BSB - Berkembang Sangat Baik</option>
                        <option value="BSH">BSH - Berkembang Sesuai Harapan</option>
                        <option value="MB">MB - Mulai Berkembang</option>
                        <option value="BB">BB - Belum Berkembang</option>
                    </select>
                    @error('nilai')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-label for="skor" value="Skor" />
                    <x-input id="skor" type="text" disabled wire:model.defer="skor"
                        class="mt-1 block w-full" />
                    @error('skor')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="update">Update</x-button>
            <x-secondary-button wire:click="$set('open', false)" class="ml-2">Batal</x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
