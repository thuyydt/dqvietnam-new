<script type="text/babel">
    const App = () => {
        const {Image} = antd;
        const [state, setState] = useState({
            logo: '',
            favicon: '',
            siteName: '',
            metaTitle: '',
            metaDescription: '',
            metaKeyword: '',
            videoTutorial: '',
            img_payleft: '',
            img_payight: '',
            pay_content: '',
            "home_banner": "/images/element-24.jfif",
            "hero_banner": "/images/dqlagi/banner.jpg",
            "social[facebook]": "",
            "social[youtube]": "",
            "social[twitter]": "",
            "social[zalo]": "",
            "social[messenger]": "",
            "social[instagram]": "",
            "company[name]": "",
            "company[email]": "",
            "company[address]": "",
            "company[phone]": "",
            "founder[name]": "",
            "founder[email]": "",
            "founder[address]": "",
            "founder[phone]": "",
            "support[name]": "",
            "support[email]": "",
            "support[address]": "",
            "support[phone]": "",
            "mail[email]": "nguoihungdq@gmail.com",
            "mail[protocol]": "smtp",
            "mail[host]": "ssl://smtp.googlemail.com",
            "mail[user]": "nguoihungdq@gmail.com",
            "mail[password]": "jlquhparybqgognp",
            "mail[port]": "465",
        });
        const [form] = Form.useForm();

        const [loading, setLoading] = useState(false);
        const [activities, setActivities] = useState([]);

        const setMedia = (image, fieldName) => {

            setState((prev) => ({...prev, [fieldName]: image}));
            form.setFieldsValue({[fieldName]: image});

        }
        const onFinish = async (data) => {
            setLoading(true);
            await API_V2.SETTING.CREATE(data);
            message.success("Lưu thành công!")
            setLoading(false);
        }

        useEffect(async () => {
            const activities = await API_V2.ACTIVITIES.GET();
            console.log('activities', activities)
            setActivities(activities)
            const setting = await API_V2.SETTING.GET();
            let toState = state;
            if (setting.data) {
                toState = setting.data.reduce((obj, item) => ({...obj, [item.key]: item.value}), {});
                setState(toState);
            }
            form.setFieldsValue(toState);
            tinymce.init({
                height: "250",
                selector: ".pay_content",
            })

        }, []);
        return <div className="container mt-4">
            <Form form={form} labelCol={{sm: 8}} onFinish={onFinish} labelAlign="left">
                <Card title="Cài đặt website"
                      extra={<Button loading={loading} htmlType="submit">Lưu thiết lập</Button>}>
                    <Tabs defaultActiveKey="1">
                        <Tabs.TabPane key="1" tab="Thông tin website">
                            <Row gutter={[24, 8]}>
                                <Col sm={14}>
                                    <Form.Item name="siteName" label="Tên website">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="metaTitle" label="Meta title">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="metaDescription" label="Meta Description">
                                        <Input.TextArea/>
                                    </Form.Item>
                                    <Form.Item name="metaKeyword" label="Meta keywords">
                                        <Input.TextArea/>
                                    </Form.Item>
                                    <Form.Item label="Video trang chủ">
                                        <Space>
                                            <Form.Item noStyle name="videoTutorial">
                                                <Input/>
                                            </Form.Item>
                                            <Button onClick={() => chooseImage('videoTutorial', setMedia)}>
                                                Chọn media
                                            </Button>
                                        </Space>
                                    </Form.Item>
                                    <Row gutter={[24, 8]}>
                                        <Col sm={6}>
                                            <Space direction="vertical">
                                                <Form.Item hidden name="home_banner">
                                                    <Input/>
                                                </Form.Item>
                                                <Button onClick={() => chooseImage('home_banner', setMedia)}>
                                                    Banner trang chủ</Button>
                                                <Image fallback={CONSTANTS.NO_IMAGE} width={100} src={state.home_banner}/>
                                            </Space>
                                        </Col>
                                        <Col sm={6}>
                                            <Space direction="vertical">
                                                <Form.Item hidden name="hero_banner">
                                                    <Input/>
                                                </Form.Item>
                                                <Button onClick={() => chooseImage('hero_banner', setMedia)}>
                                                    Banner Hero</Button>
                                                <Image fallback={CONSTANTS.NO_IMAGE} width={100} src={state.hero_banner}/>
                                            </Space>
                                        </Col>
                                    </Row>
                                </Col>
                                <Col sm={4}/>
                                <Col sm={6}>
                                    <Space direction="vertical">
                                        <Space direction="vertical">
                                            <Form.Item hidden name="logo">
                                                <Input/>
                                            </Form.Item>
                                            <Button onClick={() => chooseImage('logo', setMedia)}>Chọn Logo</Button>
                                            <Image fallback={CONSTANTS.NO_IMAGE} width={100} src={state.logo}/>
                                        </Space>
                                        <Space direction="vertical">
                                            <Form.Item hidden name="favicon">
                                                <Input/>
                                            </Form.Item>
                                            <Button onClick={() => chooseImage('favicon', setMedia)}>Chọn
                                                Favicon</Button>
                                            <Image fallback={CONSTANTS.NO_IMAGE} width={100} src={state.favicon}/>
                                        </Space>
                                        <Space direction="vertical">
                                            <Form.Item hidden name="shareDefault">
                                                <Input/>
                                            </Form.Item>
                                            <Button onClick={() => chooseImage('shareDefault', setMedia)}>
                                                Socail share
                                            </Button>
                                            <Image fallback={CONSTANTS.NO_IMAGE} width={100} src={state.shareDefault}/>
                                        </Space>
                                    </Space>
                                </Col>
                            </Row>
                        </Tabs.TabPane>
                        <Tabs.TabPane key="2" tab="Liên hệ">
                            <Row gutter={[24, 8]}>
                                <Col sm={12}>
                                    <h4>Liên hệ chung</h4>
                                    <hr/>
                                    <Form.Item name="company[name]" label="Tên công ty">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="company[address]" label="Địa chỉ">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="company[email]" label="Email">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="company[phone]" label="Số điện thoại">
                                        <Input/>
                                    </Form.Item>
                                </Col>
                                <Col sm={12}>
                                    <h4>Liên hệ hợp tác</h4>
                                    <hr/>
                                    <Form.Item name="founder[name]" label="Tên liên hệ">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="founder[address]" label="Địa chỉ">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="founder[email]" label="Email">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="founder[phone]" label="Số điện thoại">
                                        <Input/>
                                    </Form.Item>
                                </Col>
                                <Col sm={12}>
                                    <h4>Liên hệ tư vấn</h4>
                                    <hr/>

                                    <Form.Item name="support[name]" label="Tên liên hệ">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="support[address]" label="Địa chỉ">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="support[email]" label="Email">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="support[phone]" label="Số điện thoại">
                                        <Input/>
                                    </Form.Item>
                                </Col>
                            </Row>
                        </Tabs.TabPane>
                        <Tabs.TabPane key="3" tab="Mạng xã hội">
                            <Row gutter={[24, 8]}>
                                <Col sm={12}>
                                    <Form.Item name="social[facebook]" label="Facebook">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="social[zalo]" label="Zalo">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="social[youtube]" label="Youtube">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="social[twitter]" label="Twitter">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="social[instagram]" label="Instagram">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="social[messenger]" label="Messenger">
                                        <Input/>
                                    </Form.Item>
                                </Col>
                            </Row>
                        </Tabs.TabPane>
                        <Tabs.TabPane key="4" tab="Email">
                            <Row gutter={[24, 8]}>
                                <Col sm={12}>
                                    <Form.Item name="mail[email]" label="Email">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="mail[protocol]" label="Protocol">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="mail[host]" label="Host">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="mail[user]" label="User">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="mail[password]" label="Password">
                                        <Input/>
                                    </Form.Item>
                                    <Form.Item name="mail[port]" label="Port">
                                        <Input/>
                                    </Form.Item>
                                </Col>
                            </Row>
                        </Tabs.TabPane>
                        <Tabs.TabPane key="5" tab="Thanh toán">
                            <Row gutter={[24, 8]}>
                                <Col sm={12}>
                                    <Space direction="vertical">
                                        <Space direction="vertical">
                                            <Form.Item hidden name="img_payleft">
                                                <Input/>
                                            </Form.Item>
                                            <Button onClick={() => chooseImage('img_payleft', setMedia)}>Ảnh
                                                trái</Button>
                                            <Image fallback={CONSTANTS.NO_IMAGE} width={100} src={state.img_payleft}/>
                                        </Space>
                                        <Space direction="vertical">
                                            <Form.Item hidden name="img_payright">
                                                <Input/>
                                            </Form.Item>
                                            <Button onClick={() => chooseImage('img_payright', setMedia)}>Ảnh
                                                phải</Button>
                                            <Image fallback={CONSTANTS.NO_IMAGE} width={100} src={state.img_payright}/>
                                        </Space>
                                    </Space>
                                </Col>

                                <Col sm={12}>
                                    <Form.Item name="pay_content" label="Nội dung">
                                        <Input.TextArea rows="10"/>
                                    </Form.Item>
                                </Col>
                            </Row>
                        </Tabs.TabPane>
                        <Tabs.TabPane key="6" tab="Bảo mật">
                            <Row gutter={8}>
                                <Col md={12}>
                                    <Form.Item
                                        initialValue="true"
                                        valuePropName='checked'
                                        name="login_limit_status"
                                        label="Giới hạn đăng nhập">
                                        <Checkbox>Kích hoạt</Checkbox>
                                    </Form.Item>
                                    <Form.Item
                                        initialValue="2"
                                        name="login_limit"
                                        label="Số thiết bị cho phép">
                                        <InputNumber/>
                                    </Form.Item>
                                    <Form.Item
                                        help="Thêm ip mới xuống hàng"
                                        name="ip_locked"
                                        label="Khóa IP">
                                        <Input.TextArea rows="4"/>
                                    </Form.Item>
                                </Col>
                                <Col md={24}>
                                    <div style={{marginTop: 50}}>
                                        <Table
                                            {...activities}
                                            columns={[
                                                {
                                                    title: 'Tài khoản',
                                                    'dataIndex': 'account',
                                                    key: 'account',
                                                    render: account => {
                                                        return account ? account.username : '__'
                                                    }
                                                },
                                                {title: 'IP', dataIndex: 'ip', key: 'ip'},
                                                {title: 'Tên thiết bị', dataIndex: 'device', key: 'device'},
                                                {
                                                    title: 'Ngày đăng nhập',
                                                    dataIndex: 'last_logged',
                                                    key: 'last_logged',
                                                    render: toDate
                                                },
                                            ]}
                                        />
                                    </div>
                                </Col>
                            </Row>
                        </Tabs.TabPane>
                    </Tabs>
                </Card>
            </Form>
        </div>
    }
    ReactDOM.render(<App/>, document.getElementById('app'));
</script>
