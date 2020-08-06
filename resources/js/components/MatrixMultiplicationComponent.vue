<template>
  <div class="container">
    <h1>MATRIX</h1>

        <div class="row col-12">
            <div class="border col-12 mt-5 p-5 row shadow5" v-if="resultingMatrix">
                    <h5 class="col-12 mb-5"> RESULTING MATRIX</h5>
                    <div class="table-responsive col-12">
                        <table class="table table-bordered table-sm">
                            <thead class="bg-success text-white">
                                <th class="text-uppercase text-center">#</th>
                                <th v-for="n in resultingMatrix[0].length" class="text-uppercase text-center">
                                    {{ columnLetter(n-1) }}
                                </th>
                            </thead>
                            <tbody>
                                <tr v-for="(row, rowIndex) in resultingMatrix" :key="rowIndex" class="flex w-100">
                                    <th  scope="row">{{rowIndex+1}}</th>
                                    <td v-for="(column, columnIndex) in row" :key="columnIndex">
                                        <div class="input-group input-group-lg justify-content-center">
                                            {{ row[columnIndex] }}                                   
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    <div class="row">

        <div class="my-5 col-12">
            <button class="btn btn-lg btn-primary" v-on:click="multiplyMatrices()"> Multiply </button>
        </div>
        

        <div class="col-md-6 border col-md-6 p-3 rounded-lg shadow" v-for="(setup, index) in matrixSetup" :key="setup.id">
            <h5>Matrix {{index + 1}}</h5>
            <div class="row">
                <div class="form-group col-12">
                    <label>
                       Number of Columns
                    </label>
                    <input type="number" class="form-control" :class="{'is-invalid': errors.has(index+'.columns')}" 
                        v-model.number="setup.columns"  v-on:change="generateMatrix(setup)">

                        <p class="invalid-feedback" v-show="errors.has(index+'.columns')">
                            <strong>{{ errors.get(index+'.columns') }}</strong>
                        </p>
                </div>
                
                <div class="form-group col-12">
                    <label>
                       Number of Rows
                    </label>
                    <input type="number" class="form-control " :class="{'is-invalid': errors.has(index+'.rows')}"
                        v-model.number="setup.rows"  v-on:change="generateMatrix(setup)">

                        <p class="invalid-feedback" v-show="errors.has(index+'.rows')">
                            <strong>{{ errors.get(index+'.rows') }}</strong>
                        </p>
                </div>

                <div class="row col-12 mt-5" v-if="setup.matrix">
                    <h5 class="col-12"> Please fill your Matrix</h5>
                    <div class="table-responsive col-12">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <th>#</th>
                                <th v-for="n in setup.columns" class="text-uppercase text-center">
                                    {{ columnLetter(n-1) }}
                                </th>
                            </thead>
                            <tbody>
                                <tr v-for="(row, rowIndex) in setup.matrix" :key="rowIndex" class="flex w-100">
                                    <th  scope="row">{{rowIndex+1}}</th>
                                    <td v-for="(column, columnIndex) in row" :key="columnIndex">
                                        <div class="input-group input-group-lg">
                                            <input type="number" class="form-control" style="min-width: 60px" v-model.number="row[columnIndex]">
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
</template>

<script>
export default {
  data: () => {
    return {
      matrixSetup: [
          {
              id: 'first',
              columns: null,
              rows: null,
              matrix: null,
          },
          {
              id: 'second',
              columns: null,
              rows: null,
              matrix: null,
          },
      ],
      errors:new Errors(),
      resultingMatrix: null,
    };
  },
  methods: {
       generateMatrix(setup) {
            if (setup.rows && setup.columns) {
                setup.matrix = new Array();
                for (let index = 0; index < setup.rows; index++) {
                    let row = [];
                    for (let index = 0; index < setup.columns; index++) {
                        row.push(0)
                    }
                    setup.matrix.push(row);
                }
            }
        },
        multiplyMatrices() {
            this.errors.clear();
            axios.post('matrix', this.matrixSetup)
                .then(
                    (res) => {
                        this.resultingMatrix = res.data;
                    }
                ).catch(error => {
                    this.errors.record(error.response.data.errors);
                });
        },
        columnLetter(i) {
           return (i >= 26 ? this.columnLetter((i / 26 >> 0) - 1) : '') +  'abcdefghijklmnopqrstuvwxyz'[i % 26 >> 0];
        }
  }
};
</script>