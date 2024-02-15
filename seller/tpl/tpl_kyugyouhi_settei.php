<?php
$html = '
    <div class="row">
        <div class="col-md-6">
            <h1 id="currentMonthHeader"></h1>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">日</th>
                        <th scope="col">月</th>
                        <th scope="col">火</th>
                        <th scope="col">水</th>
                        <th scope="col">木</th>
                        <th scope="col">金</th>
                        <th scope="col">土</th>
                    </tr>
                </thead>
                <tbody id="currentMonthTable">
                    <!-- Current months dates will be inserted here dynamically -->
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h1 id="nextMonthHeader"></h1>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">日</th>
                        <th scope="col">月</th>
                        <th scope="col">火</th>
                        <th scope="col">水</th>
                        <th scope="col">木</th>
                        <th scope="col">金</th>
                        <th scope="col">土</th>
                    </tr>
                </thead>
                <tbody id="nextMonthTable">
                    <!-- Next months dates will be inserted here dynamically -->
                </tbody>
            </table>
        </div>
    </div>    
';
echo $html;
