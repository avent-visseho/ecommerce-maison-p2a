@extends('layouts.admin')

@section('title', 'Valeurs - ' . $attribute->name)
@section('page-title', 'Gestion des Valeurs')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.attributes.index') }}" class="text-neutral-400 hover:text-neutral-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-neutral-900">Valeurs de l'attribut : {{ $attribute->name }}</h2>
                <p class="text-sm text-neutral-400 mt-1">
                    Type:
                    @if($attribute->type === 'color')
                        <span class="badge badge-primary">Couleur</span>
                    @elseif($attribute->type === 'text')
                        <span class="badge badge-secondary">Texte</span>
                    @else
                        <span class="badge badge-neutral">Sélection</span>
                    @endif
                </p>
            </div>
            <button onclick="document.getElementById('createValueModal').classList.remove('hidden')"
                class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nouvelle Valeur</span>
            </button>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Total Valeurs</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ $values->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Actives</p>
                        <h3 class="text-2xl font-bold text-green-600">{{ $values->where('is_active', true)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            @if($attribute->type === 'color')
                <div class="bg-white rounded-xl p-5 border border-neutral-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-neutral-400 mb-1">Avec Code Couleur</p>
                            <h3 class="text-2xl font-bold text-blue-600">{{ $values->whereNotNull('color_hex')->count() }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Values List -->
        <div class="card">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-neutral-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    @if($attribute->type === 'color')
                                        Aperçu
                                    @else
                                        #
                                    @endif
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Valeur
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Code
                                </th>
                                @if($attribute->type === 'color')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                        Code Couleur
                                    </th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Ordre
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-neutral-200">
                            @forelse($values as $value)
                                <tr class="hover:bg-neutral-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($attribute->type === 'color' && $value->color_hex)
                                            <div class="w-10 h-10 rounded-lg border-2 border-neutral-300 shadow-sm"
                                                style="background-color: {{ $value->color_hex }}"></div>
                                        @else
                                            <span class="text-neutral-400">#{{ $loop->iteration }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-neutral-900">{{ $value->value }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-neutral-600 font-mono">{{ $value->code }}</span>
                                    </td>
                                    @if($attribute->type === 'color')
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-neutral-600 font-mono">{{ $value->color_hex ?? '-' }}</span>
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($value->is_active)
                                            <span class="badge badge-success">Actif</span>
                                        @else
                                            <span class="badge badge-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-neutral-600">{{ $value->sort_order }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button onclick="editValue({{ $value->id }}, '{{ $value->value }}', '{{ $value->code }}', '{{ $value->color_hex }}', {{ $value->sort_order }}, {{ $value->is_active ? 'true' : 'false' }})"
                                                class="text-primary-500 hover:text-primary-700">
                                                Modifier
                                            </button>
                                            <form action="{{ route('admin.attributes.values.destroy', [$attribute, $value]) }}" method="POST"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette valeur ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $attribute->type === 'color' ? '7' : '6' }}" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <p class="text-neutral-400 text-lg mb-2">Aucune valeur trouvée</p>
                                        <p class="text-sm text-neutral-400 mb-4">Créez votre première valeur pour cet attribut</p>
                                        <button onclick="document.getElementById('createValueModal').classList.remove('hidden')"
                                            class="btn-primary inline-flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Créer une valeur
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Value Modal -->
    <div id="createValueModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-neutral-900">Nouvelle Valeur</h3>
                <button onclick="document.getElementById('createValueModal').classList.add('hidden')"
                    class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.attributes.values.store', $attribute) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Valeur</label>
                    <input type="text" name="value" class="input-field" placeholder="Ex: Rouge, Petit, Coton" required>
                    @error('value')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Code unique</label>
                    <input type="text" name="code" class="input-field" placeholder="Ex: red, small, cotton" required>
                    <p class="text-xs text-neutral-400 mt-1">Utilisez des lettres minuscules sans espaces</p>
                    @error('code')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if($attribute->type === 'color')
                    <div>
                        <label class="label">Code Couleur (Hex)</label>
                        <div class="flex items-center space-x-2">
                            <input type="color" name="color_hex" id="color_picker" class="w-12 h-12 rounded cursor-pointer border border-neutral-300">
                            <input type="text" name="color_hex_text" id="color_hex_text" class="input-field flex-1" placeholder="#FF0000" pattern="^#[0-9A-Fa-f]{6}$">
                        </div>
                        <p class="text-xs text-neutral-400 mt-1">Format: #RRGGBB (ex: #FF0000 pour rouge)</p>
                        @error('color_hex')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div>
                    <label class="label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" class="input-field" value="0" min="0">
                    @error('sort_order')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active_create" value="1" checked
                        class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500">
                    <label for="is_active_create" class="ml-2 text-sm text-neutral-700">Actif</label>
                </div>

                <div class="flex items-center space-x-3 pt-4">
                    <button type="submit" class="flex-1 btn-primary">Créer la valeur</button>
                    <button type="button" onclick="document.getElementById('createValueModal').classList.add('hidden')"
                        class="flex-1 btn-secondary">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Value Modal -->
    <div id="editValueModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-neutral-900">Modifier Valeur</h3>
                <button onclick="document.getElementById('editValueModal').classList.add('hidden')"
                    class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editValueForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="label">Valeur</label>
                    <input type="text" name="value" id="edit_value" class="input-field" required>
                </div>

                <div>
                    <label class="label">Code unique</label>
                    <input type="text" name="code" id="edit_code" class="input-field" required>
                </div>

                @if($attribute->type === 'color')
                    <div>
                        <label class="label">Code Couleur (Hex)</label>
                        <div class="flex items-center space-x-2">
                            <input type="color" name="color_hex" id="edit_color_picker" class="w-12 h-12 rounded cursor-pointer border border-neutral-300">
                            <input type="text" name="color_hex_text" id="edit_color_hex" class="input-field flex-1" pattern="^#[0-9A-Fa-f]{6}$">
                        </div>
                    </div>
                @endif

                <div>
                    <label class="label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" id="edit_sort_order" class="input-field" min="0">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                        class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500">
                    <label for="edit_is_active" class="ml-2 text-sm text-neutral-700">Actif</label>
                </div>

                <div class="flex items-center space-x-3 pt-4">
                    <button type="submit" class="flex-1 btn-primary">Sauvegarder</button>
                    <button type="button" onclick="document.getElementById('editValueModal').classList.add('hidden')"
                        class="flex-1 btn-secondary">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Sync color picker with text input (Create)
            @if($attribute->type === 'color')
                const colorPicker = document.getElementById('color_picker');
                const colorHexText = document.getElementById('color_hex_text');

                if (colorPicker && colorHexText) {
                    colorPicker.addEventListener('input', function() {
                        colorHexText.value = this.value.toUpperCase();
                    });

                    colorHexText.addEventListener('input', function() {
                        if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
                            colorPicker.value = this.value;
                        }
                    });
                }
            @endif

            function editValue(id, value, code, colorHex, sortOrder, isActive) {
                document.getElementById('edit_value').value = value;
                document.getElementById('edit_code').value = code;
                document.getElementById('edit_sort_order').value = sortOrder;
                document.getElementById('edit_is_active').checked = isActive;

                @if($attribute->type === 'color')
                    if (colorHex) {
                        document.getElementById('edit_color_picker').value = colorHex;
                        document.getElementById('edit_color_hex').value = colorHex;
                    }

                    // Sync edit modal color picker
                    const editColorPicker = document.getElementById('edit_color_picker');
                    const editColorHex = document.getElementById('edit_color_hex');

                    editColorPicker.addEventListener('input', function() {
                        editColorHex.value = this.value.toUpperCase();
                    });

                    editColorHex.addEventListener('input', function() {
                        if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
                            editColorPicker.value = this.value;
                        }
                    });
                @endif

                document.getElementById('editValueForm').action = `/admin/attributes/{{ $attribute->id }}/values/${id}`;
                document.getElementById('editValueModal').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection
