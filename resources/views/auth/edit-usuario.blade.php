@extends('layouts.admin-Lti')

@section('content')
<style>
    /* Animações e estilos modernos */
    .fade-in {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Moderno */
    .card-modern {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .card-modern:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
    }

    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 30px;
        color: white;
    }

    .card-header-modern h3 {
        margin: 0;
        font-weight: 600;
    }

    .card-header-modern p {
        margin: 5px 0 0;
        opacity: 0.9;
    }

    .card-body-modern {
        padding: 30px;
    }

    /* Formulário */
    .form-group-modern {
        margin-bottom: 25px;
    }

    .label-modern {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .label-modern i {
        margin-right: 8px;
        color: #667eea;
    }

    .input-modern {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        width: 100%;
        transition: all 0.3s ease;
        background: #f9fafb;
        font-size: 0.95rem;
    }

    .input-modern:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .input-modern.is-invalid {
        border-color: #f56565;
        background: #fff5f5;
    }

    .select-modern {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        width: 100%;
        background: #f9fafb;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .select-modern:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Avatar upload */
    .avatar-upload {
        text-align: center;
        margin-bottom: 30px;
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .avatar-preview:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-preview i {
        font-size: 48px;
        color: white;
    }

    .avatar-upload input {
        display: none;
    }

    .avatar-hint {
        font-size: 0.75rem;
        color: #6c757d;
    }

    /* Botões */
    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-secondary-modern {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-secondary-modern:hover {
        transform: translateY(-2px);
        color: white;
    }

    .btn-warning-modern {
        background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-warning-modern:hover {
        transform: translateY(-2px);
        color: white;
    }

    /* Alertas */
    .alert-modern {
        border: none;
        border-radius: 16px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .alert-success-modern {
        background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
        color: #1e7e34;
    }

    .alert-danger-modern {
        background: linear-gradient(135deg, #feb2b2 0%, #fc8181 100%);
        color: #c53030;
    }

    .invalid-feedback-modern {
        color: #f56565;
        font-size: 0.8rem;
        margin-top: 5px;
        display: block;
    }

    hr {
        background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
        height: 2px;
        border: none;
        margin: 20px 0;
    }

    /* Breadcrumb */
    .breadcrumb-modern {
        margin-bottom: 25px;
    }

    .breadcrumb-modern .breadcrumb {
        background: transparent;
        padding: 0;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .card-body-modern {
            padding: 20px;
        }

        .btn-primary-modern, .btn-secondary-modern, .btn-warning-modern {
            width: 100%;
            margin-top: 10px;
        }

        .text-right {
            text-align: center !important;
        }
    }

    /* Loading spinner */
    .loading-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.6s ease-in-out infinite;
        margin-right: 8px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Avatar existente */
    .current-avatar {
        font-size: 0.75rem;
        margin-top: 8px;
        color: #6c757d;
    }
</style>

<div class="container-fluid fade-in">
    <!-- Breadcrumb -->
    <div class="breadcrumb-modern">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-users"></i> Utilizadores</a>
            </li>
            <li class="breadcrumb-item active">
                <i class="fa fa-edit"></i> <b>Actualizar Utilizador</b>
            </li>
        </ol>
    </div>

    <!-- Card Principal -->
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card-modern">
                <div class="card-header-modern">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-user-circle fa-3x mr-3"></i>
                        <div>
                            <h3 class="mb-0">
                                Actualizar Utilizador
                            </h3>
                            <p class="mb-0">Edite as informações do utilizador no sistema</p>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern">
                    <!-- Mensagens de Sucesso/Erro -->
                    @isset($success)
                        <div class="alert alert-success-modern alert-modern">
                            <i class="fa fa-check-circle mr-2"></i> {{ $mensage ?? 'Operação realizada com sucesso!' }}
                        </div>
                    @endisset

                    @isset($error)
                        <div class="alert alert-danger-modern alert-modern">
                            <i class="fa fa-exclamation-triangle mr-2"></i> {{ $mensage ?? 'Erro ao processar solicitação' }}
                        </div>
                    @endisset

                    @if ($errors->any())
                        <div class="alert alert-danger-modern alert-modern">
                            <i class="fa fa-exclamation-triangle mr-2"></i>
                            <strong>Por favor, corrija os seguintes erros:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('Usuarios.update', $usuario->id) }}" enctype="multipart/form-data" id="userForm">
                        @csrf
                        @method('PUT')

                        <!-- Avatar Upload -->
                        <div class="avatar-upload">
                            <div class="avatar-preview" onclick="$('#avatarInput').click()">
                                @if($usuario->avatar ?? false)
                                    <img id="avatarPreview" src="{{ asset('storage/' . $usuario->avatar) }}" alt="Avatar">
                                @else
                                    <i class="fa fa-camera"></i>
                                    <img id="avatarPreview" src="#" alt="Avatar" style="display: none;">
                                @endif
                            </div>
                            <input type="file" name="avatar" id="avatarInput" accept="image/*">
                            <div class="avatar-hint">
                                <i class="fa fa-info-circle"></i> Clique para alterar a foto (opcional)
                            </div>
                            @if($usuario->avatar ?? false)
                                <div class="current-avatar">
                                    <i class="fa fa-image"></i> Foto actual
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-user"></i> Nome Completo <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="input-modern @error('name') is-invalid @enderror"
                                           name="name"
                                           value="{{ old('name', $usuario->name) }}"
                                           placeholder="Digite o nome completo do utilizador"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback-modern">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-venus-mars"></i> Sexo <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern @error('sexo') is-invalid @enderror" name="sexo" required>
                                        <option value="">Selecione...</option>
                                        <option value="M" {{ old('sexo', $usuario->sexo ?? '') == 'M' ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ old('sexo', $usuario->sexo ?? '') == 'F' ? 'selected' : '' }}>Feminino</option>
                                    </select>
                                    @error('sexo')
                                        <div class="invalid-feedback-modern">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label class="label-modern">
                                <i class="fa fa-envelope"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   class="input-modern @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email', $usuario->email) }}"
                                   placeholder="exemplo@dominio.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback-modern">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-briefcase"></i> Categoria do Funcionário <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern @error('categoria') is-invalid @enderror" name="categoria" required>
                                        <option value="">Selecione a categoria...</option>
                                        @foreach ($categoria as $categoriaItem)
                                            <option value="{{ $categoriaItem->id }}"
                                                {{ (isset($usuario->categoria) && $usuario->categoria->contains('id', $categoriaItem->id)) ? 'selected' : '' }}>
                                                {{ $categoriaItem->Descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria')
                                        <div class="invalid-feedback-modern">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-calendar"></i> Ano Lectivo <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern @error('anolectivo_id') is-invalid @enderror" name="anolectivo_id" required>
                                        <option value="">Selecione o ano lectivo...</option>
                                        @foreach ($anolectivo as $anolectivoItem)
                                            <option value="{{ $anolectivoItem->id }}"
                                                {{ (isset($usuario->anolectivo) && $usuario->anolectivo->contains('id', $anolectivoItem->id)) ? 'selected' : '' }}>
                                                {{ $anolectivoItem->anolectivo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('anolectivo_id')
                                        <div class="invalid-feedback-modern">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-layer-group"></i> Nível <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern @error('Nivel') is-invalid @enderror" name="Nivel" required>
                                        <option value="">Selecione o nível...</option>
                                        @foreach ($nivel as $nivelItem)
                                            <option value="{{ $nivelItem->id }}"
                                                {{ (isset($usuario->Nivel_id) && $usuario->Nivel_id == $nivelItem->id) ? 'selected' : '' }}>
                                                {{ $nivelItem->Descricao }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('Nivel')
                                        <div class="invalid-feedback-modern">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label class="label-modern">
                                        <i class="fa fa-tasks"></i> Papel/Função <span class="text-danger">*</span>
                                    </label>
                                    <select class="select-modern @error('role') is-invalid @enderror" name="role" required>
                                        <option value="">Selecione o papel...</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ (isset($usuario->roles) && $usuario->roles->contains('id', $role->id)) ? 'selected' : '' }}>
                                                {{ $role->label }}
                                                @if($role->permission->count())
                                                    ({{ $role->permission->pluck('label')->implode(', ') }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback-modern">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ route('Usuarios.index') }}" class="btn-secondary-modern">
                                    <i class="fa fa-arrow-left mr-2"></i> Voltar
                                </a>
                                @isset($trashed)
                                    <a href="{{ route('Usuarios.userrestore', $usuario->id) }}" class="btn-warning-modern ml-2">
                                        <i class="fa fa-refresh mr-2"></i> Recuperar Utilizador
                                    </a>
                                @endisset
                                <button type="submit" class="btn-primary-modern ml-2" id="submitBtn">
                                    <i class="fa fa-save mr-2"></i> Actualizar Dados
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Preview de avatar
        $('#avatarInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire('Erro', 'A imagem não pode exceder 2MB', 'error');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatarPreview').attr('src', e.target.result).show();
                    $('.avatar-preview i').hide();
                }
                reader.readAsDataURL(file);
            }
        });

        // Validação do formulário
        $('#userForm').on('submit', function(e) {
            let isValid = true;

            $(this).find('[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                Swal.fire('Atenção!', 'Por favor, preencha todos os campos obrigatórios.', 'warning');
            } else {
                const btn = $('#submitBtn');
                btn.html('<span class="loading-spinner"></span> A processar...').prop('disabled', true);
            }
        });

        // Remover classe de erro ao digitar
        $('input, select').on('input change', function() {
            if ($(this).val()) {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback-modern').remove();
            }
        });
    });
</script>
@endpush

@push('style')
<link rel="stylesheet" href="{{ asset('Registo/css/styles.min.css') }}" />
@endpush

@endsection
