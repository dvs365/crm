
<?php

use yii\widgets\Menu;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea xmlns="http://www.w3.org/1999/html">
    <?= Menu::widget([
        'items' => [
            ['label' => 'Все', 'url' => ['/client/index']],
            ['label' => 'Создать', 'url' => ['/client/create']],
            ['label' => 'Свободные', 'url' => ['/client/free']],
            ['label' => 'Потенциальные', 'url' => ['/client/target']],
            ['label' => 'Рабочие', 'url' => ['/client/load']],
            ['label' => 'Отказные', 'url' => ['/client/reject']],
            ['label' => 'Статистика', 'url' => ['/client/statistic'], 'visible' => Yii::$app->user->can('moder')],
        ],
        'activeCssClass' => 'cur',
        'options' => [
            'cust-dop-menu-horizontal' => '',
        ]
    ])?>
    <h1><?= Html::encode($this->title)?><?= ($model->anchor) ? '<span>&#9875</span>' : ''?></h1>
    <div cust-content>
        <div col1>
            <div cust-inf-block>
                <div class="expand-link-com-inf" tit inf>Общая информация <span up>&#9652</span><span down>&#9662</span></div>
                <div class="expand-block-com-inf"><?= Html::a('Редактировать', ['update', 'id' => $model->id], ['cust-edit' => '', 'size14' => ''])?>
                    <span expand-link-movetorefused cust-edit size14>Перенести в отказные</span>
                    <?php $form = ActiveForm::begin([
                        'action' => ['client/toreject'],
                        'method' => 'post',
                        'options' => [
                            'expand-block-movetorefused' => ''
                        ]
                    ]); ?>
                        <?= $form->field($reject, 'client_id')->label(false)->hiddenInput(['value' => $model->id])?>
                        <?= $form->field($reject, 'reason', ['template' => '{input}'])->textarea(['rows' => 4, 'placeholder' => 'Укажите причину переноса'])?>
                        <?= Html::submitInput('Перенести')?>
                    <?php ActiveForm::end(); ?>
                    <? if ($model->clientJurs[0]->name) {?>
                    <p><span size14>Юр. лицо:</span><br />
                        <? foreach ($model->clientJurs as $indexClientJur => $clientJur) {
                            if (!$clientJur->name) continue;
                            echo ($indexClientJur) ? '<br /><span size14 gray>'.Html::encode($clientJur->name) . '</span>' : '<span size14>' . Html::encode($clientJur->name) . '</span>';
                        }?>
                    </p>
                    <?}?>
					<? if($model->clientContacts[0]->name) {
						foreach ($model->clientContacts as $indexContact => $clientContact) {?>
							<p><?= Html::encode($clientContact->name . ' ')?><u comment><?= Html::encode($clientContact->position)?></u>
							<? foreach ($clientContact->clientContactPhones as $clientContactPhone) {?>
									<?= '<br />' . Html::encode($clientContactPhone->country . ' ' . $clientContactPhone->city . ' ' . $clientContactPhone->number) . ' ' . '<u comment>' . Html::encode($clientContactPhone->comment) . '</u>'?>
								<?}?>
								<? foreach ($clientContact->clientContactMails as $clientContactMail) {?>
									<?= '<br />' . Html::encode($clientContactMail->address) . ' ' . '<u comment>' . Html::encode($clientContactMail->comment) . '</u>'?>
								<?}?>
							</p>
						<?}
					}?>
					<? if ($model->clientPhones[0]->phone || $model->clientMails[0]->address) {?>
						<p>Контакты клиента:
						<? if ($model->clientPhones[0]->phone) {
							foreach ($model->clientPhones as $clientPhone) {?>
								<?= '<br />' . Html::encode($clientPhone->country . ' ' . $clientPhone->city . ' ' . $clientPhone->number) . ' ' . '<u comment>' . Html::encode($clientPhone->comment) . '</u>'?>
							<?}
						}
						if ($model->clientMails[0]->address) {
							foreach ($model->clientMails as $clientMail) {?>
								<?= '<br />' . Html::encode($clientMail->address) . ' <u comment>' . Html::encode($clientMail->comment) . '</u>'?>
							<?}
						}?>
						</p>
					<?}?>
					<? if ($model->clientAddresses[0]->city && $model->clientAddresses[0]->region && $model->clientAddresses[0]->country) {
						foreach ($model->clientAddresses as $clientAddress) {?>
							<p><?= Html::encode($clientAddress->city . ', ' . $clientAddress->region . ', ' . $clientAddress->country)?></p>
						<?}
					}?>
                </div>
            </div>
			<div cust-inf-block actions>
				<?= Html::a('<div tit>Действия</div>', '#')?>
				<div korpus>
					<input type="radio" name="odin" checked="checked" id="vkl1"/>
					<label for="vkl1">Звонок</label>
					<input type="radio" name="odin" id="vkl2"/>
					<label for="vkl2">Письмо</label>
					<div call-mail-wr>
						<form>
							<div call-mail-forms>
								<p><input name="date" type="text" id="datepicker" value="" /></p>
								<input class="to-save" type="text" title="Результат звонка" placeholder="Результат звонка (коротко)" />
								<textarea class="to-save" title="Дополнительные комментарии" placeholder="Дополнительные комментарии"></textarea>
								<input type="submit" value="Сохранить" />
							</div>
						</form>
						<table>
							<tr>
								<td>09.10.16</td>
								<td><?= Html::a('Результат звонка', '#')?></td>
							</tr>
							<tr>
								<td>05.10.16</td>
								<td><?= Html::a('Результат звонка', '#')?></td>
							</tr>
							<tr>
								<td>02.10.16</td>
								<td><?= Html::a('Результат звонка Результат звонка Результат звонка', '#')?></td>
							</tr>
						</table>
					</div>
					<div call-mail-wr>
						<form>
							<div call-mail-forms>
								<select name="kontakt" id="kontakt" onChange="the_kontakt(this); document.user.submit(); return false;">
									<option value="0">Иванов Иван Иванович /основное к. лицо/</option>
									<option value="0">Козырев Дмитрий Николаевич</option>
									<option value="0">Дмитрюк Валерий Сергеевич</option>
								</select>
								<select name="mail" id="mail" onChange="the_mail(this); document.user.submit(); return false;">
									<option value="0">ivanov@flexy.ru /мыло основного к. лица/</option>
									<option value="0">buhgalter@mail.ru</option>
									<option value="0">manager@mail.ru</option>
								</select>
								<input class="to-save" type="text" title="Отправить копию" placeholder="Отправить копию?" />
								<textarea class="to-save" title="Сообщение" placeholder="Сообщение" /></textarea>
								<input type="submit" value="Отправить" />
							</div>
						</form>
						<table>
							<tr>
								<td>09.10.16</td>
								<td><?= Html::a('Текст письма....', '#')?></td>
							</tr>
							<tr>
								<td>05.10.16</td>
								<td><?= Html::a('Текст письма....', '#')?></td>
							</tr>
							<tr>
								<td>02.10.16</td>
								<td><?= Html::a('Текст письма....', '#')?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div cust-inf-block delivery>
				<?= Html::a('<div tit>Доставка товара</div>', '#')?>
				<table>
					<tr>
						<td>№ счета</td>
						<td>№ накладной</td>
						<td>Дата отгрузки</td>
						<td>ТК</td>
						<td>Статус</td>
					</tr>
					<tr>
						<td>145</td>
						<td>476/15</td>
						<td>09.10.16</td>
						<td>Байкал-сервис</td>
						<td status>
							<div state>
								<input type="checkbox" class="checkbox" id="checkbox-1" />
								<label for="checkbox-1"></label>
							</div>
						</td>
					</tr>
					<tr>
						<td>141</td>
						<td>12/15</td>
						<td>02.10.16</td>
						<td>Деловые линии</td>
						<td status>
							<div state>
								<input type="checkbox" class="checkbox" id="checkbox-2" />
								<label for="checkbox-2"></label>
							</div>
						</td>
					</tr>
				</table>
			</div>
        </div>
		<div col2>
			<div cust-inf-block doing>
				<div tit><?= Html::a('Дела', ['todo/index'])?><?= Html::a('<span add></span>', ['todo/create', 'client_id' => $model->id], ['title' => 'Добавить'])?></div>
				<table>
					<? if ($model->todos[0]) {
						foreach ($model->todos as $todo) {?>
							<tr>
								<td gray><?= \DateTime::createFromFormat('Y-m-d H:i:s', $todo->time_to)->format('d.m.y')?></td>
								<td descript><?= Html::a($todo->name, ['todo/update', 'id' => $todo->id])?></td>
								<?= ($todo->time_to < date('Y-m-d H:i')) ? '<td red bold>Просроченo' : '<td orange>На сегодня'?></td>
							</tr>
						<?}
					}?>
				</table>
			</div>
			<div cust-inf-block contract>
				<div tit><?= Html::a('Договоры', '#')?><?= Html::a('<span add></span>', '#', ['title' => 'Добавить'])?></div>
				<table>
					<tr>
						<td>№</td>
						<td>Дата</td>
						<td>Тип</td>
						<td>Статус</td>
					</tr>
					<tr>
						<td><a href="#">145</a></td>
						<td>09.10.16</td>
						<td>Предоплата</td>
						<td status>
							<div state>
								<input type="checkbox" class="checkbox" id="checkbox-3" />
								<label for="checkbox-3"></label>
							</div>
						</td>
					</tr>
					<tr>
						<td><a href="#">143</a></td>
						<td>07.10.16</td>
						<td>Отсрочка</td>
						<td status>
							<div state>
								<input type="checkbox" class="checkbox" id="checkbox-4" />
								<label for="checkbox-4"></label>
							</div>
						</td>
					</tr>
					<tr>
						<td><a href="#">140</a></td>
						<td>04.10.16</td>
						<td>Реализация</td>
						<td status>
							<div state>
								<input type="checkbox" class="checkbox" id="checkbox-5" />
								<label for="checkbox-5"></label>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div cust-inf-block invoice>
				<?= Html::a('<div tit>Счета</div>', '#')?>
				<table>
					<tr>
						<td>№</td>
						<td>Дата</td>
						<td>Сумма</td>
						<td>Статус</td>
					</tr>
					<tr>
						<td><a href="#">145</a></td>
						<td>09.10.16</td>
						<td>120 900</td>
						<td status>
							<div state>
								<input type="checkbox" class="checkbox" id="checkbox-6" />
								<label for="checkbox-6"></label>
							</div>
						</td>
					</tr>
					<tr>
						<td><a href="#">143</a></td>
						<td>07.10.16</td>
						<td>36 495</td>
						<td status>
							<div state>
								<input type="checkbox" class="checkbox" id="checkbox-7" />
								<label for="checkbox-7"></label>
							</div>
						</td>
					</tr>
					<tr>
						<td><a href="#">140</a></td>
						<td>04.10.16</td>
						<td>50 000</td>
						<td status>
							<div state>
								<input type="checkbox" class="checkbox" id="checkbox-8" />
								<label for="checkbox-8"></label>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div cust-inf-block booking>
				<?= Html::a('<div tit>Заказы</div>', '#')?>
				<p size14>Скидка: <span size18>10%</span></p>
				<table>
					<tr>
						<td>Дата</td>
						<td>Время</td>
						<td>Сумма</td>
						<td></td>
					</tr>
					<tr>
						<td>09.10.16</td>
						<td><a href="#">10:38</a></td>
						<td>35 000</td>
						<td><a href="#">Выставить счет</a></td>
					</tr>
					<tr>
						<td>09.10.16</td>
						<td><a href="#">16:04</a></td>
						<td>120 900</td>
						<td><a href="#">Выставить счет</a></td>
					</tr>
				</table>
			</div>
		</div>
    </div>
</div>