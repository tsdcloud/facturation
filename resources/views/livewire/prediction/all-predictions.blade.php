<div>
    <div class="tables-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <small class=" text-black">facture annulée en rouge</small>
                    <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
                        <div class="left">
                            <p>Afficher <span>10</span> factures</p>
                        </div>
                        <div class="right">
                            <div class="table-search d-flex">
                                <form action="#">
                                    <input type="text" wire:model.debounce.500ms="search_invoice_no_tractor_trailer"
                                        placeholder="Entrer le n° facture ou tracteur" />
                                    <button><i class="lni lni-search-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                                <tr>
                                    <th>Opérations</th>
                                    <th>Partenaires</th>
                                    <th>Vehicules</th>
                                    <th>Remorques</th>
                                    <th>N° conteneur</th>
                                    <th>N° plomb</th>
                                    <th>Chargeur</th>
                                    <th>Produit</th>
                                    <th>Chef de guerite entrée</th>
                                    <th>Pont entrée</th>
                                    <th>Date pesée entrée</th>
                                    <th>Status pesée</th>
                                    <th>Chef guerite sortie</th>
                                    <th>Pont sortie</th>
                                    <th>Date pesée sortie</th>
                                    <th>Ajouter par</th>
                                </tr>
                                <!-- end table row-->
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p></p>
                                    </td>
                                </tr>
                                <!-- end table row -->
                            </tbody>
                        </table>
                        <!-- end table -->
                    </div>
                    <div class="pt-10 d-flex flex-wrap justify-content-between ">
                        <div class="left">
                            <p class="text-sm text-gray">
                        </div>
                        <div class="">
                            {{-- {{ $invoices->links() }} --}}
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
</div>
