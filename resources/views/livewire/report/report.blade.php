<div>
    <!-- End Row -->
    <div class="row">
        <div class="col-lg-3">
            <div class="select-style-1">
                <label>Selectionner le chef de Guerite</label>
                <div class="select-position">
                    <select>
                        <option disabled selected value="" Selectionner le chef de Geurite>...</option>
                        @foreach($users as $user)
                          <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="select-style-1">
                <label>Selectionner le shift</label>
                <div class="select-position">
                    <select>
                        <option disabled selected value="" >...</option>
                            <option value="">06h30-14h31</option>
                            <option value="">14h31-22h31</option>
                            <option value="">22h31-06h31</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="input-style-1">
                <label>Périodicité du :</label>
                <input type="date" />
            </div>
        </div>
        <div class="col-lg-3">
            <div class="input-style-1">
                <label>Au:</label>
                <input type="date" />
            </div>
        </div>
        <div class="col-lg-2 mb-2 justify-content-end">
            <button class="main-btn active-btn-outline rounded-md btn-hover" type="submit">Filtrer</button>
        </div>
        <div class="col-lg-2 mb-2 justify-content-end">
            <button class="main-btn dark-btn-outline rounded-md btn-hover" type="submit">Rénitialiser le filtre</button>
        </div>
    </div>

    @php
        $i = 1
    @endphp
    <div class="row">
        <div class="col-lg-12">
            <div class="card-style mb-30">
                <h6 class="mb-10">Etat facturation</h6>
                <div class="table-wrapper table-responsive">
                    <table class="table striped-table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>
                                <h6>N° Facture</h6>
                            </th>
                            <th>
                                <h6>Emise par</h6>
                            </th>
                            <th>
                                <h6>Statut facture</h6>
                            </th>
                            <th>
                                <h6>Nom client</h6>
                            </th>
                            <th>
                                <h6>Tracteur</h6>
                            </th>
                            <th>
                                <h6>Remorque</h6>
                            </th>
                            <th>
                                <h6>Pont</h6>
                            </th>
                            <th>
                                <h6>Mode de paiment</h6>
                            </th>
                        </tr>
                        <!-- end table row-->
                        </thead>
                        <tbody>

                            <tr>
                                <td>
                                    <h6 class="text-sm">{{$i ++}}</h6>
                                </td>
                                <td>
                                    <p> </p>
                                </td>
                                {{--<td>
                                    <p>{{$movement->movement_type === "deposit" ? 'Dépôt' : '' }} </p>
                                </td>--}}
                                {{-- <td>
                                     <p>{{$movement->movement_type === "withdrawal" ? 'Retrait' : '' }} </p>
                                 </td>--}}
                                <td>
                                    <p></p>
                                </td>
                                <td>
                                    <p></p>
                                </td>
                                <td>
                                    <p></p>
                                </td>
                                <td>
                                    <p></p>
                                </td>
                                <td>
                                    <p></p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                 <p>   Montant Total : 500 000 FCFA</p>
                    <!-- end table -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>
</div>
