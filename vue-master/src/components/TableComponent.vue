<template>
    <h1>Welcome {{title}}!!!</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#Id</th>
                            <th>Contact</th>
                            <th>Phone</th>
                            <th>Date added</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in data" :key="row.id" v-bind:class="{'table-active' : index%2 == 0}"> <!--color de filamintercalado-->
                            <td>{{ row.id }} </td>
                            <td>{{ row.contact }}</td>
                            <td>{{ row.phone }}</td>
                            <td>{{ row.date }}</td>
                            <td>{{ row.status }}</td>
                            <td>
                                 
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="updateRow(index)">Update
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" @click="remove(index)">Delete
                                </button>
                                <button type="button" class="btn btn-primary btn-sm" @click="details(index)">Details...
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-mod-3">
                <!--<button type="button" class="btn btn-primary btn-sm" @click="create()">
                    Create
                </button> -->
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
                <div class="col-md-6">
                </div>
                    <div class="col-md-3">
                       
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" @click="actionAdd()">
                            Add Contact
                        </button>

                       
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header"> 
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="clearVar()"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="Id" class="form-label">Id</label><input type="number" class="form-control" id="Id" placeholder="Numero de Id" v-model="inputId">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Contact" class="form-label">Contact</label><input type="text" class="form-control" id="Contact" placeholder="Ingresa el nombre del contacto" v-model="inputContact">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Phone" class="form-label">Phone</label><input type="tel" class="form-control" id="Phone" placeholder="Ingresa numero de telefono" v-model="inputPhone">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Date" class="form-label">Date Added</label><input type="date" class="form-control" id="Date" v-model="inputDate">
                                            </div>
                                            <div class="mb-3">
                                                <label for="Status" class="form-label">Status</label>
                                                <select name="Status" class="form-control" id="Status" v-model="inputStatus">
                                                    <option selected value="Activo">Activo</option>
                                                    <option value="Inactivo">Inactivo</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="clearVar()">Close</button>
                                        <button type="button" class="btn btn-primary" @click="SavedChanges()">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-md-3">
                </div>
        </div>
	</div>
</template>

<script>
    export default{
        data(){
            return{
                /*data : [
                    {id: 1, contact: "Diana", phone: "4491575516", date: "20/11/2022", status: "Inactivo"},
                    {id: 2, contact: "Fernando", phone: "4495194587", date: "05/12/2022", status: "Activo"},
                    {id: 3, contact: "Fernanda", phone: "4490605487", date: "30/05/2022", status: "Inactivo"},
                    {id: 4, contact: "Brayan", phone: "4490123216", date: "01/07/2022", status: "Activo"},
                    {id: 5, contact: "Leticia", phone: "4492193570", date: "08/07/2022", status: "Activo"}
                ], */
                data: [],
                inputId : "",
                inputContact : "", 
                inputPhone : "",   
                inputDate : "",
                inputStatus : "", 
                action: ""      
            
            }
        },
        methods:{

            details(index){
                    const headers = { "Content-Type": "application/json" };
                    fetch("http://localhost/BackEnd/api/read_one.php?userId=" + parseInt(this.data[index].contactId))
                .then(async response => {
                    const res = await response.json();
                    if (!response.ok) {
                        const error = (res && res.message) || response.StatusText;
                        return Proimise.reject(error);
                    } else {
                        console.log(response);
                    }
                })
                .catch(error => {
                    this.errorMessage = error;
                    console.error("Ocurrio un error: ", error);
                });
            },

            actionAdd() {
                this.action = "Add";
            },

            select(id, index){
                console.log("Rowid = " + id);
                console.log("Index = " + index);

                console.log(this.data[index].Contact); /*Imprimir dato */
                this.data[index].Contact="Rodrigo"; /*Modificar dato */
                console.log(this.data[index].Contact); /*Mostrar nuevo dato */
            },

            remove(index){
                const requestOptions = {
                        method: "DELETE",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ userId: parseInt(this.data[index].contactId)})
                    };
                fetch("http://localhost/BackEnd/api/delete.php", requestOptions)
                        .then(async response => {
                            const data = await response.json();

                            if (data != "ok") {
                                const error = response.StatusText;
                                return Proimise.reject(error);
                            } else {
                                console.log(response.body);
                            }

                        }).catch(error => {
                            this.errorMessage = error;
                            console.error("Ocurrio un error: ", error);
                        });
            },

            createNew() {
            this.data.push({ id: this.inputId, Contact: this.inputContact, Phone: this.inputPhone, Date: this.inputDate, Status: this.inputStatus });
            },

            create(){ /*dato estatico*/
                this.data.push({id: 6, contact: "Maria", phone: "4492050308", date: "15/07/2022", status: "Inactivo"});
                this.data.push({ id: document.getElementById("Id").value, Contact: document.getElementById("Contact").value, Phone: document.getElementById("Phone").value, Date: document.getElementById("Date").value, Status: document.getElementById("Status").value });
            },


            saveChanges(){
				if (this.inputId != "" && this.inputContact != "" && this.inputPhone != "" && this.inputDate != "" && this.inputStatus != "") {
                if (this.action == 'Add') {
                    const requestOptions = {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ name: this.inputContact, phone: this.inputPhone, date: this.inputDate, status: this.inputStatus })
                    };

                        fetch("http://localhost/BackEnd/api/update.php", requestOptions)
                        .then(async response => {
                            const data = await response.json();

                            if (data != "ok") {
                                const error = response.StatusText;
                                return Proimise.reject(error);
                            } else {
                                console.log(response.body);
                            }

                        }).catch(error => {
                            this.errorMessage = error;
                            console.error("Ocurrio un error: ", error);
                        });
                                            alert("esto es nuevo");

						//this.data.push({id: this.inputId, contact: this.inputContact, phone: this.inputPhone, date: this.inputDate, status:this.inputStatus});
						/*this.inputId ="";
						this.inputContact ="";
						this.inputPhone ="";
						this.inputDate ="";
						this.inputStatus =""; */
						
                    } else if (this.action == 'update') {

                    const requestOptions = {
                        method: "PUT",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ userId: parseInt(this.inputId), name: this.inputContact, phone: this.inputPhone, date: this.inputDate, status: this.inputStatus })
                    };

                    fetch("http://localhost/BackEnd/api/update.php", requestOptions)
                        .then(async response => {
                            const data = await response.json();

                            if (data != "ok") {
                                const error = response.StatusText;
                                return Proimise.reject(error);
                            } else {
                                console.log(response.body);
                            }

                        }).catch(error => {
                            this.errorMessage = error;
                            console.error("Ocurrio un error: ", error);
                        });
                    alert("esto es actualizar");
                }

				} else {
					alert("Falta llenar un campo vacio");
				}
			},

			updateRow(index){
                this.action = "update";
						this.inputId = this.data[index].contactId;
                        this.inputContact = this.data[index].name;
                        this.inputPhone = this.data[index].phone;
                        this.inputDate = this.data[index].date;
                        this.inputStatus = this.data[index].status;
			},

            clearVar() {
                this.inputId = "";
                this.inputContact = "";
                this.inputPhone = "";
                this.inputDate = "";
                this.inputStatus = "";
            },

        }, 
		created() { //get
        const headers = { "Content-Type": "application/json" };
        fetch("http://localhost/BackEnd/api/read.php")
            .then(async response => {
                const res = await response.json();
                console.log(res);
                if (!response.ok) {
                    const error = (res && res.message) || response.StatusText;
                    return Proimise.reject(error);
                } else {
                    this.data = res.body;
                }
            })
            .catch(error => {
                this.errorMessage = error;
                console.error("Ocurrio un error: ", error);
            });

    },
    props: {
        title: String
    }
}
</script>



