@extends('layouts.admin')

@section('title', 'Attributs Produits')
@section('page-title', 'Gestion des Attributs')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Attributs Produits</h2>
                <p class="text-sm text-neutral-400 mt-1">Gérez les attributs réutilisables pour les variantes (couleurs, tailles, etc.)</p>
            </div>
            <button onclick="document.getElementById('createAttributeModal').classList.remove('hidden')"
                class="btn-primary flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Nouvel Attribut</span>
            </button>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Total Attributs</p>
                        <h3 class="text-2xl font-bold text-neutral-900">{{ $attributes->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Actifs</p>
                        <h3 class="text-2xl font-bold text-green-600">{{ $attributes->where('is_active', true)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-400 mb-1">Type Couleur</p>
                        <h3 class="text-2xl font-bold text-blue-600">{{ $attributes->where('type', 'color')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attributes List -->
        <div class="space-y-4">
            @forelse($attributes as $attribute)
                <div class="card group hover:shadow-md transition-all duration-200">
                    <div class="card-body">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-bold text-neutral-900">{{ $attribute->name }}</h3>
                                    <span class="text-xs px-2 py-1 rounded-full bg-neutral-100 text-neutral-600">
                                        {{ $attribute->code }}
                                    </span>
                                    @if ($attribute->type === 'color')
                                        <span class="badge badge-primary">Couleur</span>
                                    @elseif ($attribute->type === 'text')
                                        <span class="badge badge-secondary">Texte</span>
                                    @else
                                        <span class="badge badge-neutral">Sélection</span>
                                    @endif
                                    @if ($attribute->is_active)
                                        <span class="badge badge-success">Actif</span>
                                    @else
                                        <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </div>

                                <div class="flex items-center space-x-4 text-sm text-neutral-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $attribute->values->count() }} valeur{{ $attribute->values->count() > 1 ? 's' : '' }}
                                    </span>
                                </div>

                                @if ($attribute->values->count() > 0)
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        @foreach ($attribute->values->take(8) as $value)
                                            @if ($attribute->type === 'color' && $value->color_hex)
                                                <div class="flex items-center space-x-1 px-2 py-1 bg-neutral-50 rounded-lg">
                                                    <div class="w-4 h-4 rounded-full border border-neutral-300"
                                                        style="background-color: {{ $value->color_hex }}"></div>
                                                    <span class="text-xs text-neutral-600">{{ $value->value }}</span>
                                                </div>
                                            @else
                                                <span class="text-xs px-2 py-1 bg-neutral-50 rounded-lg text-neutral-600">
                                                    {{ $value->value }}
                                                </span>
                                            @endif
                                        @endforeach
                                        @if ($attribute->values->count() > 8)
                                            <span class="text-xs text-neutral-400">+{{ $attribute->values->count() - 8 }} autre(s)</span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.attributes.values', $attribute) }}"
                                    class="btn-secondary text-sm py-2 px-4">
                                    Gérer Valeurs
                                </a>
                                <button onclick="editAttribute({{ $attribute->id }}, '{{ $attribute->name }}', '{{ $attribute->code }}', '{{ $attribute->type }}', {{ $attribute->is_active ? 'true' : 'false' }})"
                                    class="btn-secondary text-sm py-2 px-4">
                                    Modifier
                                </button>
                                <form action="{{ route('admin.attributes.destroy', $attribute) }}" method="POST"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet attribut ? Toutes ses valeurs seront également supprimées.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 text-sm text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                        <p class="text-neutral-400 text-lg mb-2">Aucun attribut trouvé</p>
                        <p class="text-sm text-neutral-400 mb-4">Créez votre premier attribut pour commencer à gérer les variantes</p>
                        <button onclick="document.getElementById('createAttributeModal').classList.remove('hidden')"
                            class="btn-primary inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Créer un attribut
                        </button>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Create Attribute Modal -->
    <div id="createAttributeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-neutral-900">Nouvel Attribut</h3>
                <button onclick="document.getElementById('createAttributeModal').classList.add('hidden')"
                    class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.attributes.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Nom de l'attribut</label>
                    <input type="text" name="name" class="input-field" placeholder="Ex: Couleur, Taille, Matériau" required>
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Code unique</label>
                    <input type="text" name="code" class="input-field" placeholder="Ex: color, size, material" required>
                    <p class="text-xs text-neutral-400 mt-1">Utilisez des lettres minuscules sans espaces</p>
                    @error('code')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label">Type d'attribut</label>
                    <select name="type" class="input-field" required>
                        <option value="select">Sélection (liste déroulante)</option>
                        <option value="color">Couleur (sélecteur visuel)</option>
                        <option value="text">Texte libre</option>
                    </select>
                    @error('type')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                        class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500">
                    <label for="is_active" class="ml-2 text-sm text-neutral-700">Actif</label>
                </div>

                <div class="flex items-center space-x-3 pt-4">
                    <button type="submit" class="flex-1 btn-primary">Créer l'attribut</button>
                    <button type="button" onclick="document.getElementById('createAttributeModal').classList.add('hidden')"
                        class="flex-1 btn-secondary">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Attribute Modal -->
    <div id="editAttributeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-neutral-900">Modifier Attribut</h3>
                <button onclick="document.getElementById('editAttributeModal').classList.add('hidden')"
                    class="text-neutral-400 hover:text-neutral-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editAttributeForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="label">Nom de l'attribut</label>
                    <input type="text" name="name" id="edit_name" class="input-field" required>
                </div>

                <div>
                    <label class="label">Code unique</label>
                    <input type="text" name="code" id="edit_code" class="input-field" required>
                </div>

                <div>
                    <label class="label">Type d'attribut</label>
                    <select name="type" id="edit_type" class="input-field" required>
                        <option value="select">Sélection (liste déroulante)</option>
                        <option value="color">Couleur (sélecteur visuel)</option>
                        <option value="text">Texte libre</option>
                    </select>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                        class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-500">
                    <label for="edit_is_active" class="ml-2 text-sm text-neutral-700">Actif</label>
                </div>

                <div class="flex items-center space-x-3 pt-4">
                    <button type="submit" class="flex-1 btn-primary">Sauvegarder</button>
                    <button type="button" onclick="document.getElementById('editAttributeModal').classList.add('hidden')"
                        class="flex-1 btn-secondary">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function editAttribute(id, name, code, type, isActive) {
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_code').value = code;
                document.getElementById('edit_type').value = type;
                document.getElementById('edit_is_active').checked = isActive;
                document.getElementById('editAttributeForm').action = `/admin/attributes/${id}`;
                document.getElementById('editAttributeModal').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection
