<?php

defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/babel">
    const SCHOOL = '<?= isset($school_id) ? $school_id : '' ?>';
    const App = () => {
        const [formSearch] = Form.useForm();
        const [payments, setPayments] = useState({pagination: null, dataSource: []});
        const [isLoading, setLoading] = useState(false);

        const onGetList = async (params = {}) => {
            setLoading(true);
            const data = await API_V2.PAYMENT.GET({
                ...params,
            });
            setPayments(data);
            setLoading(false);
        }

        useEffect(() => {
            (async () => {
                await onGetList();
            })();
        }, []);

        return <section className="content">
            <Card title={<Form layout="inline" form={formSearch} onFinish={onGetList}>
                <Form.Item name="key">
                    <Input placeholder="Tên tài khoản, số điện thoại...."/>
                </Form.Item>
                <Space>
                    <Button htmlType="submit">Lọc</Button>
                    <Button htmlType="reset" onClick={onGetList}>Reset</Button>
                </Space>
            </Form>}>
                <Spin spinning={isLoading}>
                    <Table
                        {...payments}
                        onChange={({current, pageSize}) => onGetList({page: current, pageSize})}
                        columns={[
                            {title: 'Mã thanh toán', dataIndex: 'id', key: 'id', render: (id) => `DQ ${id}`},
                            {
                                title: 'Email', dataIndex: 'account', key: 'account', render: (account, raw) => {
                                    if (!account) {
                                        return '---';
                                    }
                                    return <Space direction="vertical">
                                        <a href={`mailto:${account.email}`}>{account.email}</a>
                                        <a href={`tel:${account.phone}`}>{account.phone ?? '---'}</a>
                                    </Space>
                                }
                            },
                            {title: 'Trường học', dataIndex: 'school', key: 'school', render: school => school ? school.name : '---'},
                            {title: 'Số tiền', dataIndex: 'price', key: 'price'},
                            {
                                title: 'Thời gian thanh toán',
                                dataIndex: 'created_time',
                                key: 'created_time',
                                render: toDate
                            }
                        ]}
                    />
                </Spin>
            </Card>
        </section>
    }
    ReactDOM.render(<App/>, document.getElementById('app'));
</script>
