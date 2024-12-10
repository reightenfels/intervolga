        <style>
            .all-models {
                margin-top: 100px;
            }

            .all-models__table {
                display: flex;
                flex-direction: column;
                margin-top: 50px;
            }

            .all-models__table__row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: 1px solid #dfdfdf;
                border-bottom: none;
                padding: 20px 10px;
            }

            .all-models__table__row:last-child {
                border-bottom: 1px solid #dfdfdf;
            }

            .all-models__row__title {
                font-size: 25px;
                color: #2B2B2B;
                font-weight: 600;
            }

            .all-models__row__action {
                padding: 10px 20px;
                background: #017BFE;
                border-radius: 5px;
                color: #fff;
                transition: all .3s;
                cursor: pointer;
                text-decoration: none;
            }

            .all-models__row__action:hover {
                opacity: .6;
            }
        </style>

        <div class="container all-models">
            <h1>Выберите сущность для редактирования</h1>
            <div class="all-models__table">
                <div class="all-models__table__row">
                    <div class="all-models__row__title">
                        Продукция
                    </div>
                    <a href="/products" class="all-models__row__action">
                        Перейти
                    </a>
                </div>
                <div class="all-models__table__row">
                    <div class="all-models__row__title">
                        Виды продукции
                    </div>
                    <a href="/categories" class="all-models__row__action">
                        Перейти
                    </a>
                </div>
                <div class="all-models__table__row">
                    <div class="all-models__row__title">
                        Полезные элементы
                    </div>
                    <a href="/useful_elements" class="all-models__row__action">
                        Перейти
                    </a>
                </div>
                <div class="all-models__table__row">
                    <div class="all-models__row__title">
                        Тип удобрения
                    </div>
                    <a href="/soil_types" class="all-models__row__action">
                        Перейти
                    </a>
                </div>
                <div class="all-models__table__row">
                    <div class="all-models__row__title">
                        Тип растений
                    </div>
                    <a href="/plants_types" class="all-models__row__action">
                        Перейти
                    </a>
                </div>
            </div>
        </div>