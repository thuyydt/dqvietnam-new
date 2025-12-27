<?php

defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/babel">
  const App = () => {
        const [formSearch] = Form.useForm();
        const [form] = Form.useForm();
        const [accounts, setAccounts] = useState({pagination: null, dataSource: []});
        const [roles, setRoles] = useState([]);
        const [schools, setSchools] = useState([]);
        const [isUpdate, setIsUpdate] = useState(false);
        const [visible, setVisible] = useState(false);
        const [isLoading, setLoading] = useState(false);
        const [acLoad, setAcLoad] = useState(false);
        const [isSchool, setIsSchool] = useState(true);

        const onToggle = async () => {
            setVisible(!visible);
            setIsUpdate(false);
            // form.resetFields();
            await onGetList();
        }
        const onRemove = async (rawId) => {
            await API_V2.USER.DEL(rawId).then(onGetList);
        }
        const onUpdate = async (raw) => {
            form.setFieldsValue({
                ...raw,
                birthday: moment(raw.birthday, 'YYYY-MM-DD'),
                active: (raw.active == 1 || raw.active == '1') ? 1 : 0,
                type: raw.type ? parseInt(raw.type) : null,
                school_id: raw.school_id ? parseInt(raw.school_id) : null,
            });
            setIsUpdate(true);
            setVisible(!visible);
        }
        const onChangeStt = async (rawId) => {
            await API_V2.USER.CHANGE_STT(rawId).then(onGetList);
        }
        const onGetList = async (params = {}) => {
            setLoading(true);
            const data = await API_V2.USER.GET(params);
            setAccounts(data);
            setLoading(false);
        }
        const onFinish = async (formData) => {
            setAcLoad(true);
            if (isUpdate) {
                API_V2.USER.UPDATE(formData.id, formData).then(onToggle);
            } else {
                await API_V2.USER.CREATE(formData).then(onToggle);
            }
            setAcLoad(false);
        }
        useEffect(() => {
            (async () => {
                await onGetList();
                const roles = await API_V2.USER.GET_ROLE();
                setRoles(roles.map(r => ({...r, id: parseInt(r.id)})));
                const school = await API_V2.SCHOOL.GET({pageSize: 1000});
                setSchools(school.dataSource.map(s => ({...s, id: parseInt(s.id), label: s.name, value: parseInt(s.id)})));
            })();
        }, []);

        return <section className="content">
            <Card title={<Form layout="inline" form={formSearch} onFinish={onGetList}>
                <Form.Item name="schoolIds">
                    <Select
                        style={{width: 200}}
                        options={schools}
                    />
                </Form.Item>
                <Form.Item name="key">
                    <Input placeholder="Tên tài khoản, số điện thoại...."/>
                </Form.Item>
                <Space>
                    <Button htmlType="submit">Lọc</Button>
                    <Button htmlType="reset" onClick={onGetList}>Reset</Button>
                </Space>
            </Form>} extra={<Button onClick={onToggle}>Thêm mới</Button>}>
                <Spin spinning={isLoading}>
                    <Table
                        {...accounts}
                        onChange={({current, pageSize}) => onGetList({page: current, pageSize})}
                        columns={[
                            {title: 'ID', dataIndex: 'id', key: 'id'},
                            {title: 'Tên tài khoản', dataIndex: 'username', key: 'username'},
                            {title: 'Mật khẩu', dataIndex: 'regular_pwd', key: 'regular_pwd'},
                            {title: 'Email', dataIndex: 'email', key: 'email'},
                            {
                                title: 'Số điện thoại',
                                dataIndex: 'phone',
                                key: 'phone',
                                render: (phone) => {
                                    return phone;
                                }
                            },
                            {
                                title: 'Trạng thái',
                                dataIndex: 'active',
                                key: 'active',
                                render: (active, raw) => {
                                    return <Badge onClick={() => alert('123')}
                                                  status={active ? 'success' : 'error'}
                                                  text={active ? 'Hoạt động' : 'Ngưng hoạt động'}/>
                                }
                            },
                            {
                                title: 'Hành động', key: 'action', render: (raw) => {
                                    return <Space>
                                        <Button onClick={() => onUpdate(raw)} size="small">Sửa</Button>
                                        <Popconfirm onConfirm={() => onRemove(raw.id)}
                                                    title={`Chú ý! bạn đang chọn xóa tài khoản ${raw.username}`}>
                                            <Button danger size="small">Xóa</Button>
                                        </Popconfirm>
                                    </Space>
                                }
                            },
                        ]}
                    />
                </Spin>

            </Card>
            <Modal
                open={visible}
                onCancel={onToggle}
                footer={[<Button loading={acLoad} htmlType="submit" form="crudForm">Lưu</Button>,
                    <Button onClick={onToggle}>Hủy</Button>]}
                title="Thêm/Sửa tài khoản">
                <Form id="crudForm" onFinish={onFinish}
                      labelCol={{sm: 8}}
                      labelAlign={`left`} form={form}>
                    <Form.Item hidden name="id">
                        <Input/>
                    </Form.Item>
                    <Form.Item rules={[{required: true, message: 'Tên tài khoản bắt buộc!'}]} label="Tên tài khoản"
                               name="username">
                        <Input placeholder="cauvong@gmail.com"/>
                    </Form.Item>
                    <Form.Item rules={[{required: true, message: 'Email bắt buộc!'}]} label="Emai" name="email">
                        <Input placeholder="cauvong@gmail.com"/>
                    </Form.Item>
                    {!isUpdate && <Form.Item name="password" rules={[
                        {required: true, message: 'Mật khẩu bắt buộc!'},
                    ]} label="Mật khẩu">
                        <Space>
                            <Form.Item style={{width: `100%`}} noStyle name="password">
                                <Input.Password/>
                            </Form.Item>
                            <Button onClick={() => form.setFieldsValue({password: generatePassword()})}>Tạo</Button>
                        </Space>
                    </Form.Item>
                    }
                    <Form.Item rules={[{required: true, message: 'Số điện thoại bắt buộc!'}]} label="Số điện thoại"
                               name="phone">
                        <Input placeholder="0904 255 215"/>
                    </Form.Item>

                    <Form.Item initialValue={1} label="Trạng thái" name="active">
                        <Select
                            options={[{label: 'Đang hoạt động', value: 1}, {label: 'Ngưng hoạt động', value: 0}]}
                        />
                    </Form.Item>

                    <Form.Item initialValue={1} label="Vai trò" name="type">
                        <Select
                            onChange={value => setIsSchool(value === 2)}
                            fieldNames={{label: 'name', value: 'id'}}
                            options={roles}
                        />
                    </Form.Item>
                    {isSchool && <Form.Item label="Trường học" name="school_id">
                        <Select
                            showSearch
                            filterOption={(input, option) =>
                                (option.name).toLowerCase().includes(input.toLowerCase())
                            }
                            placeholder="Chọn trường"
                            options={schools}
                            fieldNames={{label: 'name', value: 'id'}}
                        />
                    </Form.Item>}

                    <Form.Item initialValue={1} valuePropName="checked" name="sendMail" valueProp>
                        <Checkbox>Gửi thông tin đến email</Checkbox>
                    </Form.Item>
                </Form>
            </Modal>
        </section>
    }
    ReactDOM.render(<App/>, document.getElementById('app'));
</script>