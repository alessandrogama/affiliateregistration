<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <!-- <div class="row">
          <div class="col-lg-3 col-md-6 col-12">
            <mini-statistics-card
              title="Today's Money"
              value="$53,000"
              description="<span
                class='text-sm font-weight-bolder text-success'
                >+55%</span> since yesterday"
              :icon="{
                component: 'ni ni-money-coins',
                background: 'bg-gradient-primary',
                shape: 'rounded-circle',
              }"
            />
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <mini-statistics-card
              title="Today's Users"
              value="2,300"
              description="<span
                class='text-sm font-weight-bolder text-success'
                >+3%</span> since last week"
              :icon="{
                component: 'ni ni-world',
                background: 'bg-gradient-danger',
                shape: 'rounded-circle',
              }"
            />
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <mini-statistics-card
              title="New Clients"
              value="+3,462"
              description="<span
                class='text-sm font-weight-bolder text-danger'
                >-2%</span> since last quarter"
              :icon="{
                component: 'ni ni-paper-diploma',
                background: 'bg-gradient-success',
                shape: 'rounded-circle',
              }"
            />
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <mini-statistics-card
              title="Sales"
              value="$103,430"
              description="<span
                class='text-sm font-weight-bolder text-success'
                >+5%</span> than last month"
              :icon="{
                component: 'ni ni-cart',
                background: 'bg-gradient-warning',
                shape: 'rounded-circle',
              }"
            />
          </div>
        </div> -->

        <div class="row mt-4">
          <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Afiliados</p>
                <argon-button 
                @click="$router.push('/cadastro')"
                color="success" size="sm" class="ms-auto"
                  >Cadastrar</argon-button
                >
              </div>
            </div>
    <div class="py-4 container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <p class="text-uppercase text-sm">Afiliados</p>
              <div class="table-responsive">
              <table class="table text-center align-middle">
                <thead>
                  <tr>
                    <th>Username</th>
                    <th>Nickname</th>
                    <th>Email</th>
                    <th>Base %</th>
                    <th>Referenciadores</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(affiliate, index) in affiliates" :key="index">
                    <td>{{ affiliate.username }}</td>
                    <td>{{ affiliate.nickname || '-' }}</td>
                    <td>{{ affiliate.email }}</td>
                    <td>{{ affiliate.base_percentage }}%</td>
                    <td>
                      <div>
                        <button
                          class="btn btn-sm btn-outline-primary"
                          type="button"
                          :data-bs-toggle="'collapse'"
                          :data-bs-target="`#refs-${index}`"
                          aria-expanded="false"
                          :aria-controls="`refs-${index}`"
                        >
                          Ver Referenciadores
                        </button>
                        <div
                          class="collapse mt-2"
                          :id="`refs-${index}`"
                        >
                          <ul class="list-group list-group-flush">
                            <li
                              v-for="ref in affiliate.referrals"
                              :key="ref.id"
                              class="list-group-item"
                            >
                              {{ ref.referrer?.username || 'Desconhecido' }} ({{ ref.percentage }}%)
                            </li>
                            <li v-if="!affiliate.referrals || affiliate.referrals.length === 0" class="list-group-item text-muted">
                              Nenhum referenciador
                            </li>
                          </ul>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
                </table>
                </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</template>

<script setup>
import { ref, onMounted, getCurrentInstance } from "vue";
import axios from "axios";
//import MiniStatisticsCard from "@/examples/Cards/MiniStatisticsCard.vue";
import ArgonButton from "@/components/ArgonButton.vue";

const internalInstance = getCurrentInstance()
const apiAdress = internalInstance.appContext.config.globalProperties.$apiAdress

const affiliates = ref([]);

const loadAffiliates = async () => {
  try {
    const response = await axios.get(apiAdress + "/api/affiliates");
    affiliates.value = response.data;
  } catch (error) {
    console.error("Erro ao carregar afiliados:", error);
  }
};

onMounted(() => {
  loadAffiliates();
});
</script>
