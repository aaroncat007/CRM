                <!-- 底部資訊 -->
                <footer>
                    <div class="">
                        <p class="pull-right">{!! trans('web.copyright') !!} |
                            <span class="lead"> <i class="fa fa-paw"></i>{{ webInfo()->get('WebEnName','') }}</span>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /底部資訊 -->

                <!--Script Files-->
                {!! Html::script('js/jquery-1.11.3.js') !!}
                {!! Html::script('js/jquery.form.min.js') !!}
                {!! Html::script('js/jquery.validate.min.js') !!}
                {!! Html::script('js/bootstrap.min.js') !!}
                {!! Html::script('js/custom.js') !!}

                @yield('script')