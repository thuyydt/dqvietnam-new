<?php

defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/babel">
    const SCHOOL = '<?= isset($school_id) ? $school_id : '' ?>';
    const IS_ACCOUNTANT = '<?php echo isset($userInfo->roleName) ? $userInfo->roleName === 'Accountant' : false ?>';

    const App = () => {
        const [formSearch] = Form.useForm();
        const [form] = Form.useForm();
        const [accounts, setAccounts] = useState({pagination: null, dataSource: []});
        const [schools, setSchools] = useState([]);
        const [isUpdate, setIsUpdate] = useState(false);
        const [visible, setVisible] = useState(false);
        const [isLoading, setLoading] = useState(false);
        const [acLoad, setAcLoad] = useState(false);

        const onToggle = async () => {
            setVisible(!visible);
            setIsUpdate(false);
            // form.resetFields();
            await onGetList();
        }
        const onRemove = async (rawId) => {
            await API_V2.ACCOUNT.DEL(rawId).then(onGetList);
        }
        const onUpdate = async (raw) => {
            form.setFieldsValue({
                ...raw,
                active: parseInt(raw.active),
                schools_id: raw.schools_id && raw.schools_id != 0 ? raw.schools_id : null,
                gender: parseInt(raw.gender),
                type: raw.type ? parseInt(raw.type) : 0,
                birthday: raw.birthday ? moment(raw.birthday, 'YYYY-MM-DD') : null
            });
            setIsUpdate(true);
            setVisible(!visible);
        }
        const onChangeStt = async (rawId) => {
            await API_V2.ACCOUNT.CHANGE_STT(rawId).then(onGetList);
        }
        const onGetList = async (params = {}) => {
            setLoading(true);
            if (SCHOOL) {
                params = {
                    ...params,
                    schoolIds: [SCHOOL]
                }
            }
            const data = await API_V2.ACCOUNT.GET({
                ...params,
            });
            setAccounts(data);
            setLoading(false);
        }
        const onFinish = async (formData) => {
            setAcLoad(true);
            if (isUpdate) {
                API_V2.ACCOUNT.UPDATE(formData.id, formData).then(onToggle);
            } else {
                await API_V2.ACCOUNT.CREATE(formData).then(onToggle);
            }
            setAcLoad(false);
        }
        const onExportExcel = async () => {
            window.open('/v2/account/export');
        }
        useEffect(() => {

            (async () => {
                await onGetList();
                const school = await API_V2.SCHOOL.GET({pageSize: 1000});
                setSchools(school.dataSource);
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
            </Form>} extra={<Space>
                <Button type="primary" onClick={onExportExcel}>Xuất dữ liệu</Button>
                <Button onClick={onToggle}>Thêm mới</Button>
            </Space>}>
                <Spin spinning={isLoading}>
                    <Table
                        {...accounts}
                        onChange={({current, pageSize}) => onGetList({page: current, pageSize})}
                        columns={[
                            {title: 'Mã thanh toán', dataIndex: 'id', key: 'id', render: (id) => `DQ ${id}`},
                            {
                                title: 'Email', dataIndex: 'username', key: 'username', render: (email, raw) => {
                                    return <Space direction="vertical">
                                        <a href={`mailto:${email}`}>{email}</a>
                                        <a href={`tel:${raw.phone}`}>{raw.phone ?? '---'}</a>
                                    </Space>
                                }
                            },
                            {
                                title: 'Điểm số',
                                dataIndex: 'point_sum_point',
                                key: 'point_sum_point',
                                render: (point) => point ?? 0
                            },
                            {
                                title: 'Trạng thái',
                                dataIndex: 'active',
                                key: 'active',
                                render: (active, raw) => {
                                    return <Badge status={active ? 'success' : 'error'}
                                                  text={active ? 'Active' : 'Disabled'}/>
                                }
                            },
                            {
                                title: 'Thanh toán',
                                dataIndex: 'is_payment',
                                key: 'is_payment',
                                render: (payment, raw) => {
                                    if (!IS_ACCOUNTANT) {
                                        return <Badge status={payment ? 'success' : 'processing'}
                                                      text={payment ? 'Đã thanh toán' : 'Chờ thanh toán'}/>
                                    }
                                    return <Popconfirm onConfirm={() => onChangeStt(raw.id)}
                                                       title="Chuyển trang thái thanh toán?">
                                        <Badge status={payment ? 'success' : 'processing'}
                                               text={payment ? 'Đã thanh toán' : 'Chờ thanh toán'}/>
                                    </Popconfirm>
                                }
                            },
                            {title: 'Ngày đăng ký', dataIndex: 'created_time', key: 'created_time', render: toDate},
                            {
                                title: 'Hành động', key: 'action', render: (raw) => {
                                    return <Space>
                                        <Button onClick={() => onUpdate(raw)} size="small">Sửa</Button>
                                        {!IS_ACCOUNTANT && <Popconfirm onConfirm={() => onRemove(raw.id)}
                                                                       title={`Chú ý! bạn đang chọn xóa tài khoản ${raw.username}`}>
                                            <Button danger size="small">Xóa</Button>
                                        </Popconfirm>}
                                        <Button size="small">
                                            <a href={`/admin/account/${raw.id}`}>Chi tiết</a>
                                        </Button>
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
                    <Form.Item
                        initialValue={SCHOOL}
                        hidden name="fromSchool">
                        <Input/>
                    </Form.Item>
                    <Form.Item hidden name="id">
                        <Input/>
                    </Form.Item>
                    <Form.Item label="Họ và tên" name="full_name">
                        <Input placeholder="Nguyen Van A"/>
                    </Form.Item>
                    <Form.Item rules={[{required: true, message: 'Email bắt buộc!'}]} label="Email" name="username">
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
                    <Form.Item label="Ngày sinh"
                               name="birthday">
                        <DatePicker format="YYYY-MM-DD"/>
                    </Form.Item>
                    <Form.Item initialValue={1} label="Trạng thái" name="active">
                        <Select
                            options={[{label: 'Đang hoạt động', value: 1}, {label: 'Ngưng hoạt động', value: 0}]}
                        />
                    </Form.Item>
                    <Form.Item initialValue={1} label="Giới tính" name="gender">
                        <Radio.Group>
                            <Radio value={1}>Nam</Radio>
                            <Radio value={2}>Nữ</Radio>
                        </Radio.Group>
                    </Form.Item>
                    <Form.Item initialValue={0} label="Loại tài khoản" name="type">
                        <Select
                            options={[{label: 'Cá nhân', value: 0}, {label: 'Nhà trường', value: 1}]}
                        />
                    </Form.Item>

                    <Form.Item disabled={GLOBAL_SCHOOL !== ''} initialValue={GLOBAL_SCHOOL} label="Trường học"
                               name="schools_id">
                        <Select
                            showSearch
                            filterOption={(input, option) =>
                                (option.name).toLowerCase().includes(input.toLowerCase())
                            }
                            placeholder="Chọn trường"
                            options={schools}
                            fieldNames={{label: 'name', value: 'id'}}
                        />
                    </Form.Item>
                    <Form.Item initialValue={1} valuePropName="checked" name="sendMail" valueProp>
                        <Checkbox>Gửi thông tin đến email</Checkbox>
                    </Form.Item>
                </Form>
            </Modal>
        </section>
    }
    ReactDOM.render(<App/>, document.getElementById('app'));
</script>
