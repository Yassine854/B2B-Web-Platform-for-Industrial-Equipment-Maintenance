<template>
    <SideBar>
      <h5>Utilisateurs</h5>
      <br>
      <div class="container shadow p-3" style="background-color: white; position: relative;" >
        <div class="row">
        <div class="col-md-4">
          <div class="input-group rounded">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" v-model="searchUser" @keyup="search()" />
            <span class="input-group-text border-0" id="search-addon">
              <i class="fas fa-search"></i>
            </span>
          </div>
        </div>
        <div class="col-md-8 text-end">
          <button type="button" class="btn btn-primary">Ajouter</button>
        </div>
      </div>
      <br>
        <table class="table table-striped caption-top">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nom</th>
              <th scope="col">E-mail</th>
              <th scope="col">Vérification E-mail</th>
              <th scope="col">Role</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody v-if="users.length > 0">
            <tr v-for="user in displayedUsers" :key="user.id">
              <th scope="row">{{ user.id }}</th>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td></td>
              <td>
                <button disabled class="btn btn-info btn-sm">
                  {{ user.role === 2 ? "admin" : "client" }}
                </button>
              </td>
              <td>
                <a id="crudBtn" href="" class="me-4 text-info">
                  <i class="fa-solid fa-eye"></i>
                </a>
                <a id="crudBtn" class="me-4 text-warning">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <a id="crudBtn" @click="deleteUser(user.id)" class="text-danger">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <p>Pas d'utilisateurs</p>
          </tbody>
        </table>
        <nav aria-label="User pagination" v-if="totalPages > 1" class="pb-1">
          <ul class="pagination justify-content-end">
            <li
              class="page-item"
              :class="{ active: page === currentPage }"
              v-for="page in totalPages"
              :key="page"
              style="cursor: pointer"
            >
              <a class="page-link shadow" @click="changePage(page)">{{ page }}</a>
            </li>
          </ul>
        </nav>
      </div>
    </SideBar>
  </template>

  <script setup>
  import SideBar from "../../layouts/SideBar.vue";
  import { checkLoginStatus } from "../../../auth";
  import { onMounted, ref, computed } from "vue";
  import { useRouter } from "vue-router";
  import Swal from "sweetalert2";

  window.Swal = Swal;

  let users = ref([]);
  const currentPage = ref(1);
  const itemsPerPage = ref(7); // Set the default number of items per page
  let searchUser=ref([]);

  onMounted(async () => {
    getUsers();
  });

  const getUsers = async () => {
    let response = await axios.get("/api/get_all_users");
    users.value = response.data.users;
    console.log("users are", JSON.stringify(users.value, null, 2));
  };

  const search=async()=>{
    let response=await axios.get("/api/search_user?s="+searchUser.value);
    console.log('response',response);
    users.value=response.data.users;
    users.value=response.data.users;
}





  //Page numbers
  const displayedUsers = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return users.value.slice(startIndex, endIndex);
  });

  const totalPages = computed(() =>
    Math.ceil(users.value.length / itemsPerPage.value)
  );

  const changePage = (page) => {
    currentPage.value = page;
  };
  </script>

  <script>
  export default {
    data() {
      return {
        users: {},
      };
    },
    created() {
        if (window.Laravel.user) {
                this.id = window.Laravel.user.id;
            }
        },
    methods: {
      deleteUser(user_id) {
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        }).then((result) => {
          if (result.isConfirmed) {
            if(this.id==user_id){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Il y a eu un problème!',
                })
            }
            else{
              axios.post('/api/user/delete/'+user_id).then((response)=>{
                  this.getUsers();
                  console.log(response);
              }).catch((errors)=>{
                  console.log(errors);
              })
            Swal.fire("Deleted!", "Your file has been deleted.", "success");
          }
        }
        });
      },
    },
  };
  </script>

  <style>
  /* Add your custom styles here if needed */
  #crudBtn {
    cursor: pointer;
  }
  </style>
