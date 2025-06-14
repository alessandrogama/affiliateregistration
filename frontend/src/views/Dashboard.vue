<template>
  <div class="py-4 container-fluid">
    <div class="row">
      <div class="col-lg-12">
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
                            <th>JSON</th>
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
                                    <li
                                      v-if="!affiliate.referrals || affiliate.referrals.length === 0"
                                      class="list-group-item text-muted"
                                    >
                                      Nenhum referenciador
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </td>
                            <td>
                              <button
                                class="btn btn-sm btn-outline-dark"
                                type="button"
                                :data-bs-toggle="'modal'"
                                :data-bs-target="`#jsonModal-${index}`"
                              >
                                Ver JSON
                              </button>

                              <!-- Modal -->
                              <div
                                class="modal fade"
                                :id="`jsonModal-${index}`"
                                tabindex="-1"
                                role="dialog"
                                :aria-labelledby="`jsonModalLabel-${index}`"
                                aria-hidden="true"
                              >
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content text-start">
                                    <div class="modal-header">
                                      <h5 class="modal-title" :id="`jsonModalLabel-${index}`">
                                        Dados do Afiliado - {{ affiliate.username }}
                                      </h5>
                                      <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                      ></button>
                                    </div>
                                    <div class="modal-body">
                                      <pre>{{ JSON.stringify(affiliate, null, 2) }}</pre>
                                    </div>
                                    <div class="modal-footer">
                                      <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                      >
                                        Fechar
                                      </button>
                                    </div>
                                  </div>
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
