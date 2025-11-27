<div class="card-header py-2">
    <div class="d-flex flex-wrap align-items-center gap-2">

        <div class="dropdown flex-shrink-0">

            <button class="btn btn-secondary dropdown-toggle"
                    type="button"
                    id="dropdownMailbox"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                <i class="bi bi-folder-fill me-2"></i>

                <span class="d-none d-md-inline">Dossiers</span>

            </button>

            <ul class="dropdown-menu" aria-labelledby="dropdownMailbox">
                <li>
                    <a class="dropdown-item text-success fw-bold bg-light" href="#">
                        <i class="bi bi-pencil-square me-2"></i>
                        Nouveau message
                    </a>
                </li>


                <li>
                    <a class="dropdown-item active" href="#">
                        <i class="bi bi-inbox-fill me-2"></i>
                        Boîte de réception
                        <span class="badge bg-danger rounded-pill ms-2">5</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-star-fill me-2 text-warning"></i>
                        Importants
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-send-fill me-2"></i>
                        Envoyés
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-file-earmark-code me-2"></i>
                        Brouillons
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="bi bi-trash-fill me-2"></i>
                        Corbeille
                    </a>
                </li>
            </ul>
        </div>

        <form class="d-flex flex-grow-1 gap-2">

            <input class="form-control flex-grow-1"
                   type="search"
                   placeholder="Rechercher un message..."
                   aria-label="Search">

            <button class="btn btn-primary flex-shrink-0" type="submit">
                <i class="bi bi-search"></i>
                <span class="d-none d-md-inline ms-1">Rechercher</span>
            </button>

            <button class="btn btn-outline-secondary flex-shrink-0" type="reset">
                <i class="bi bi-x-circle"></i>
                <span class="d-none d-md-inline ms-1">Reset</span>
            </button>

        </form>

    </div>
</div>