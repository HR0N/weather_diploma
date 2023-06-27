@extends('layouts.app')

@section('content')
    <div class="adminpanel_wrap">
        @if(count($data['groups']) > 0)
            <div class="adminpanel">

                <div class="groups">
                        <label>Групи в яких знаходиться бот
                            <select name="groups" id="groups" class="form-control">
                                <option value="null" selected disabled>- // -</option>
                                @foreach($data['groups'] as $group)
                                <option value="{{ $group['group_id'] }}">{{ $group['group_title'] }}</option>
                                @endforeach
                            </select>
                        </label>

                    <div class="change_city hide">
                        <label>Вибрати місто:
                            <select type="text" class="form-control">
                                @foreach($data['cities'] as $k => $v)
                                    <option value="<?= $k ?>"><?= $v ?></option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                        <div class="allow_message hide">
                            <label>Дозволити повідомлення
                                <input type="checkbox" name="messages_permission" checked>
                            </label>
                        </div>
                </div>

                <form class="message_period hide">
                    <label>0:00<input type="checkbox" value="0" name="0"></label>
                    <label>1:00<input type="checkbox" value="1" name="1"></label>
                    <label>2:00<input type="checkbox" value="2" name="2"></label>
                    <label>3:00<input type="checkbox" value="3" name="3"></label>
                    <label>4:00<input type="checkbox" value="4" name="4"></label>
                    <label>5:00<input type="checkbox" value="5" name="5"></label>

                    <label>6:00<input type="checkbox" value="6" name="6"></label>
                    <label>7:00<input type="checkbox" value="7" name="7"></label>
                    <label>8:00<input type="checkbox" value="8" name="8"></label>
                    <label>9:00<input type="checkbox" value="9" name="9"></label>
                    <label>10:00<input type="checkbox" value="10" name="10"></label>
                    <label>11:00<input type="checkbox" value="11" name="11"></label>

                    <label>12:00<input type="checkbox" value="12" name="12"></label>
                    <label>13:00<input type="checkbox" value="13" name="13"></label>
                    <label>14:00<input type="checkbox" value="14" name="14"></label>
                    <label>15:00<input type="checkbox" value="15" name="15"></label>
                    <label>16:00<input type="checkbox" value="16" name="16"></label>
                    <label>17:00<input type="checkbox" value="17" name="17"></label>

                    <label>18:00<input type="checkbox" value="18" name="18"></label>
                    <label>19:00<input type="checkbox" value="19" name="19"></label>
                    <label>20:00<input type="checkbox" value="20" name="20"></label>
                    <label>21:00<input type="checkbox" value="21" name="21"></label>
                    <label>22:00<input type="checkbox" value="22" name="22"></label>
                    <label>23:00<input type="checkbox" value="23" name="23"></label>
                </form>

                <form class="message_type hide">
                    <div class="message_type__title">
                        Виберіть тип повідомлень для цієї групи
                    </div>
                    <div class="message_type__choose">
                        <label>
                            <input type="radio" name="choose_msg_type" value="0">
                            <div class="description">
                                <span>Дата</span>
                                <span>Температура</span>
                            </div>
                        </label>

                        <label>
                            <input type="radio" name="choose_msg_type" value="1">
                            <div class="description">
                                <span>Дата</span>
                                <span>Температура</span>
                                <span>Відчувається</span>
                                <span>Тиск</span>
                                <span>Вологість</span>
                                <span>Вітер</span>
                            </div>
                        </label>
                    </div>
                </form>

                <div class="buttons">
                    <button class="btn btn-outline-dark save hide">Оновити</button>
                </div>

                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            </div>
        @else
            <div class="no_groups">
                <h3>На даний момент бот не знаходиться в жодній групі.</h3>
            </div>
        @endif
        @guest()
            <div class="test" style="position: absolute; color: #4c0000; font-weight: bold; transform: translateY(-20px)">
                Наразі тут немає перевірки на адміністратора. Для простоти налагодження.
            </div>
        @endguest
    </div>
    <script>
        let backData = null;
        backData = <?php echo json_encode($data['groups'], JSON_HEX_TAG); ?>;
    </script>
@endsection
